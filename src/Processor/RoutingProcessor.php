<?php

namespace Insidion\SwaggerBundle\Processor;


use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\AnnotationReader;
use Insidion\SwaggerBundle\Annotation\Swagger;
use Insidion\SwaggerBundle\Annotation\SwaggerParameter;
use Insidion\SwaggerBundle\Annotation\SwaggerResult;
use Insidion\SwaggerBundle\Exception\InvalidConfigurationException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Router;

/**
 * Processes the routing configuration in the project and generates the JSON needed for Swagger accordingly.
 * Can either directly during web request (not recommended), or during warming of the cache if this has been enabled by configuration
 *
 * Class RoutingProcessor
 * @package Insidion\SwaggerBundle\Processor
 */
class RoutingProcessor
{
    /**
     * @var array
     */
    protected static $ALLOWED_HTTP_METHODS = [
      'GET', 'POST', 'DELETE', 'PUT',
      'PATCH', 'HEAD', 'OPTIONS'
    ];

    /* @var RouteCollection $routeCollection */
    private $routeCollection;

    /* @var array $config */
    private $config;

    public function __construct(Router $router, $config)
    {
        $this->routeCollection = $router->getRouteCollection();
        $this->config = $config;
    }

    /**
     * Processes all the routes in the application to build the swagger json. Generates an array containing all the paths.
     *
     * @return array Contains all the paths as keys, the data as value
     */
    public function process()
    {
        $reader = new AnnotationReader();

        $paths = array();
        /* @var Route $route */
        foreach ($this->routeCollection->getIterator() as $route) {
            $routeMethod = $this->getReflectionMethodForRoute($route);
            if($routeMethod === null){
                continue;
            }

            /** @var Swagger $swaggerAnnotation */
            $swaggerAnnotation = $reader->getMethodAnnotation($routeMethod, Swagger::class);
            if ($swaggerAnnotation === null || $swaggerAnnotation->showInDocs === false) {
                continue;
            }

            /**
             * Throw an exception if the developper
             * supplied an unsupported method
             */
            $invalidHttpMethod = array_diff($route->getMethods(), self::$ALLOWED_HTTP_METHODS);
            if($invalidHttpMethod){
                if(count($invalidHttpMethod) === 1){
                    throw new \InvalidArgumentException(
                      'Path ' . $route->getPath() . ' : Swagger does not supports this HTTP method: ' . implode(', ', $invalidHttpMethod)
                    );
                }else{
                    throw new \InvalidArgumentException(
                      'Path ' . $route->getPath() . ' : Swagger does not supports these HTTP methods: ' . implode(', ', $invalidHttpMethod)
                    );
                }
            }

            $path = explode('.', $route->getPath())[0];
            if (!isset($paths[$path])){
                $paths[$path] = array();
            }

            // Prepare the data for the route.
            $allAnnotations = $reader->getMethodAnnotations($routeMethod);
            $routeData = array(
                "operationId" => $this->getOperationId($swaggerAnnotation, $this->extractControllerDefaultFromRoute($route)),
                "summary" => $swaggerAnnotation->summary,
                "description" => $swaggerAnnotation->description,
                "deprecated" => $swaggerAnnotation->deprecated,
                "security" => $swaggerAnnotation->security,
                "produces" => $swaggerAnnotation->produces,
                "consumes" => $swaggerAnnotation->consumes,
                "responses" => $this->createResponsesForRoute($allAnnotations),
                "parameters" => $this->createParametersForRoute($route, $allAnnotations),
            );

            if ($swaggerAnnotation->tags !== null) {
                $routeData["tags"] = $swaggerAnnotation->tags;
            }

            // Set the data for each method. Needed for when a route can handle multiple methods.
            foreach ($route->getMethods() as $method) {
                $methodKey = strtolower($method);
                $paths[$path][$methodKey] = $routeData;
                $paths[$path][$methodKey]['operationId'] = str_ireplace('{method}', $methodKey, $paths[$path][$methodKey]['operationId']);

                if(in_array($method, ['GET', 'HEAD']) && !empty($routeData["parameters"])){
                    foreach ($routeData["parameters"] as $parameter) {
                        if($parameter['in'] === 'body'){
                            throw new \RuntimeException(sprintf('Operation "%s": Request with GET/HEAD method cannot have body.', $routeData['operationId']));
                        }
                    }
                }
            }
        }

        return $paths;
    }

    /**
     * Creates a responses array for the route which has those annotations passes into this function
     *
     * @param $annotations array Annotations on an object
     * @return array Possible response types
     */
    private function createResponsesForRoute($annotations)
    {
        $responses = array();

        foreach ($annotations as $annotation) {
            if ($annotation instanceof SwaggerResult) {
                /* @var SwaggerResult $annotation */
                $response = array(
                    "description" => $annotation->description
                );
                if($annotation->schema !== null) {
                    $schema = $this->processSchemaType($annotation);
                    $nativeSchemas = array('string', 'number', 'integer', 'boolean', 'file');
                    if( array_search($annotation->schema, $nativeSchemas) != false) {
                        $response['schema']['type'] = $annotation->schema;
                    } else {
                        $response['schema'] = $schema;
                    }
                }
                $responses[$annotation->status] = $response;
            }
        }
        return $responses;
    }

    /**
     * @param Route $route
     * @param $annotations
     * @return array Parameters for this call
     */
    private function createParametersForRoute(Route $route, $annotations) {
        $parameters = array();

        preg_match_all('/{[_a-zA-Z]*}*/', $route->getPath(), $matches);
        $pathRequirements = array_filter(array_map(function($v) {
            return trim(substr($v, 1, -1));
        }, $matches[0]));

        $allowedInUrl = array('string', 'number', 'integer', 'boolean', 'array', 'file');
        foreach ($pathRequirements as $pathRequirement) {
            if(strpos($pathRequirement, "_") === 0) continue;
            $parameters[] = array(
                "in" => "path",
                "name" => $pathRequirement,
                "type" => "string",
                "required" => true,
            );
        }

        /* @var SwaggerParameter $annotation*/
        foreach($annotations as $annotation) {
            if(!$annotation instanceof SwaggerParameter) continue;
            $index = $this->findParameterInArray($parameters, $annotation->name);
            if($index === false) {
                $parameters[] = array(
                  "in" => $annotation->in,
                  "name" => $annotation->name,
                  "description" => $annotation->description,
                  "required" => $annotation->required,
                  "schema" => $annotation->in == "body" ? $this->processSchemaType($annotation) : $annotation->schema,
                );
            } else {
                if(array_search($annotation->schema, $allowedInUrl) === false) {
                    throw new InvalidConfigurationException(sprintf("Schema type %s not allowed as path parameter!", $annotation->schema));
                }
                $parameters[$index]['description'] = $annotation->description;
                $parameters[$index]['type'] = $annotation->schema;
                $parameters[$index]['required'] = $annotation->required;
            }
        }

        return $parameters;
    }

    /**
     * @param $annotation
     * @return array
     */
    private function processSchemaType(Annotation $annotation) {
        $schema = $annotation->schema;
        if(strpos($schema, '#') === 0) {
            // It is a reference to a definition
            $schema = array(
                "\$ref" => "#/definitions/" . substr($schema, 1)
            );
        }

        if($annotation->isArray) {
            $schema = array(
                'type' => 'array',
                'items' => $schema
            );
        }

        return $schema;
    }

    /**
     * @param $parameters
     * @param $parameter
     * @return bool|string
     */
    private function findParameterInArray($parameters, $parameter) {
        foreach($parameters as $key => $value)
        {
            if ($value['name'] === $parameter)
                return $key;
        }
        return false;
    }

    /**
     * Returns the ReflectionMethod class for a route.
     * @param $route Route
     * @return null|\ReflectionMethod
     */
    private function getReflectionMethodForRoute(Route $route)
    {
        $class = $this->extractClassFromRoute($route);
        $method = $this->extractFunctionFromRoute($route);

        if ($class !== null && $method !== null) {
            return new \ReflectionMethod($class, $method);
        }
        return null;
    }

    /**
     * Retrieves the operation ID from the Swagger annotation. Throws exception if it is not defined (required).
     * @param Swagger $swagger
     * @param string $method
     * @return mixed
     */
    private function getOperationId(Swagger $swagger, $method)
    {
        $operationId = $swagger->operationId;
        if (!isset($operationId)) {
            throw new InvalidConfigurationException(sprintf(
                "The operationId option of the Swagger annotation on route method %s has not been filled! Please do so.",
                $method
            ));
        }
        return $operationId;
    }

    /**
     * Extract the full class (including namespace) from a route definition
     * @param Route $route route
     *
     * @return string
     */
    private function extractClassFromRoute(Route $route)
    {
        $controller = explode('::', $this->extractControllerDefaultFromRoute($route));

        return isset($controller[0]) ? $controller[0] : null;
    }

    private function extractControllerDefaultFromRoute(Route $route)
    {
        $controller = $route->getDefault('_controller');

        if (!isset($controller)) {
            return null;
        }
        return $controller;
    }

    /**
     * Extracts the function name from a route definition
     * @param Route $route route
     *
     * @return \ReflectionMethod
     */
    private function extractFunctionFromRoute(Route $route)
    {
        $controller = explode('::', $this->extractControllerDefaultFromRoute($route));

        return isset($controller[1]) ? $controller[1] : null;
    }
}