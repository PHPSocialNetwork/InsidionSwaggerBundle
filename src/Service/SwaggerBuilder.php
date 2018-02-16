<?php

namespace Insidion\SwaggerBundle\Service;


use Insidion\SwaggerBundle\Exception\InvalidConfigurationException;
use Insidion\SwaggerBundle\Processor\RoutingProcessor;
use Insidion\SwaggerBundle\Processor\SchemaProcessor;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

/**
 * Responsible for orchestrating the creation of the swagger definition file.
 * Class SwaggerBuilder
 * @package Insidion\SwaggerBundle\Service
 */
class SwaggerBuilder implements CacheWarmerInterface
{
    const PSR6_CACHE_KEY = 'swagger_bundle_build';

    /**
     * @var array
     */
    private $swaggerConfig;

    /**
     * @var bool
     */
    private $swaggerConfigEnabled;

    /**
     * @var CacheItemPoolInterface
     **/
    private $swaggerCacheService;

    /**
     * @var string
     **/
    private $swaggerCacheDir;

    /**
     * @var RoutingProcessor
     */
    private $routingProcessor;

    /**
     * @var SchemaProcessor
     */
    private $schemaProcessor;

    /**
     * SwaggerDocGenerator constructor.
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @throws \RuntimeException
     */
    public function __construct(ContainerInterface $container)
    {
        $this->swaggerConfig = $container->getParameter('morlack.swagger.info');
        $this->swaggerCacheDir = $container->getParameter('kernel.cache_dir') . '/swagger/';
        $this->routingProcessor = $container->get('swagger.processor.routing');
        $this->schemaProcessor = $container->get('swagger.processor.schema');

        if(!empty($container->getParameter('morlack.swagger.cache')[ 'enabled' ])){
            $this->swaggerConfigEnabled = true;
        }

        if (!empty($container->getParameter('morlack.swagger.cache')[ 'service' ])) {
            $this->swaggerCacheService = $container->get(
              $container->getParameter('morlack.swagger.cache')[ 'service' ],
              ContainerInterface::NULL_ON_INVALID_REFERENCE
            );

            if ($this->swaggerCacheService === null) {
                throw new InvalidConfigurationException(sprintf(
                  'The service "%s" that you provided was not found by the container.',
                  $container->getParameter('morlack.swagger.cache')[ 'service' ]
                ));
            }

            if (!($this->swaggerCacheService instanceof CacheItemPoolInterface)) {
                throw new InvalidConfigurationException(sprintf(
                  'The service "%s" that you provided does not implements CacheItemPoolInterface interface.',
                  $container->getParameter('morlack.swagger.cache')[ 'service' ]
                ));
            }
        }
    }


    /**
     * @return string
     */
    public function getJsonSwaggerBuild()
    {
        return json_encode($this->getSwaggerBuild());
    }

    /**
     * Build the Swagger schema
     *
     * @return array
     */
    public function getSwaggerBuild()
    {
        if($swagger = $this->getSwaggerBuildCache()){
            return $swagger;
        }

        $swagger = $this->swaggerConfig;
        $swagger[ 'swagger' ] = '2.0';

        $paths = $this->routingProcessor->process();
        if (count($paths) > 0) {
            $swagger[ 'paths' ] = $paths;
        }

        $schemes = $this->schemaProcessor->process();
        if (count($schemes) > 0) {
            $swagger[ 'definitions' ] = $schemes;
        }

        /**
         * Sort tags Alphabetically
         */
        usort($swagger[ 'tags' ], function ($a, $b) {
            return strcmp($a[ "name" ], $b[ "name" ]);
        });

        $this->setSwaggerBuildCache($swagger);

        return $swagger;
    }

    protected function getSwaggerBuildCache()
    {
        if($this->swaggerConfigEnabled){
            if($this->swaggerCacheService){
                $cacheItem = $this->swaggerCacheService->getItem(self::PSR6_CACHE_KEY);
                if($cacheItem->isHit() && is_array($cacheItem->get())){
                    return $cacheItem->get();
                }
            }else{
                $content = file_get_contents($this->swaggerCacheDir . 'swagger.json');
                if($content){
                    return json_decode($content);
                }
            }
        }
        return null;
    }

    /**
     * @param array $build
     * @return void
     * @throws \Psr\Cache\InvalidArgumentException
     */
    protected function setSwaggerBuildCache(array $build)
    {
        if($this->swaggerConfigEnabled){
            if($this->swaggerCacheService){
                $cacheItem = $this->swaggerCacheService->getItem(self::PSR6_CACHE_KEY);
                $cacheItem->set($build)->expiresAfter(86400);
                $this->swaggerCacheService->save($cacheItem);
            }else{
                $fs = new FileSystem();
                $fs->dumpFile($this->swaggerCacheDir . 'swagger.json', json_encode($build));
            }
        }
    }


    /**
     * @throws \Psr\Cache\InvalidArgumentException
     * @return void
     */
    public function warmupSwaggerBuildCache()
    {
        if($this->swaggerConfigEnabled){
            if($this->swaggerCacheService){
                $this->swaggerCacheService->deleteItem(self::PSR6_CACHE_KEY);
            }else{
                $fs = new FileSystem();
                $fs->remove($this->swaggerCacheDir . 'swagger.json');
            }
            $this->getSwaggerBuild();
        }
    }

    /**
     * @param string $cacheDir
     */
    public function warmUp($cacheDir)
    {
        $this->warmupSwaggerBuildCache();
    }

    /**
     * @return bool
     */
    public function isOptional()
    {
        return true;
    }
}