<?php

namespace Insidion\SwaggerBundle\Service;


use Insidion\SwaggerBundle\Processor\RoutingProcessor;
use Insidion\SwaggerBundle\Processor\SchemaProcessor;

/**
 * Responsible for orchestrating the creation of the swagger definition file.
 * Class SwaggerBuilder
 * @package Insidion\SwaggerBundle\Service
 */
class SwaggerBuilder
{
    /* @var array $swaggerConfig */
    private $swaggerConfig;

    /* @var RoutingProcessor $routingProcessor */
    private $routingProcessor;

    /* @var SchemaProcessor $routingProcessor */
    private $schemaProcessor;

    public function __construct($swaggerConfig, RoutingProcessor $routingProcessor, SchemaProcessor $schemaProcessor)
    {
        $this->swaggerConfig = $swaggerConfig;
        $this->routingProcessor = $routingProcessor;
        $this->schemaProcessor = $schemaProcessor;
    }

    /**
     * Combines the loose parts to a complete whole, then encodes it in json and returns it
     *
     * @return string Swagger JSON
     */
    public function buildSwagger()
    {
        $swagger = $this->swaggerConfig;
        $swagger['swagger'] = '2.0';


        $paths = $this->routingProcessor->process();
        if (count($paths) > 0) $swagger['paths'] = $paths;
        $schemes = $this->schemaProcessor->process();
        if (count($schemes) > 0) $swagger['definitions'] = $schemes;


        return json_encode($swagger);
    }
}