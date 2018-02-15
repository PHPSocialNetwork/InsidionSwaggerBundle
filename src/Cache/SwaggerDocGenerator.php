<?php

namespace Insidion\SwaggerBundle\Cache;


use Insidion\SwaggerBundle\Service\SwaggerBuilder;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class SwaggerDocGenerator implements CacheWarmerInterface
{
    /* @var \Psr\Cache\CacheItemPoolInterface $swaggerBuilder */
    private $cacheService;

    /* @var SwaggerBuilder $swaggerBuilder */
    private $swaggerBuilder;

    /* @var string $cacheDir **/
    private $cacheDir;

    /**
     * SwaggerDocGenerator constructor.
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param \Insidion\SwaggerBundle\Service\SwaggerBuilder $builder
     * @param $cacheDir
     * @throws \RuntimeException
     */
    public function __construct(ContainerInterface $container, SwaggerBuilder $builder, $cacheDir)
    {
        $cacheSettings = $container->getParameter('morlack.swagger.cache');
        if(!empty($cacheSettings['cache_service'])){
            if(is_array($cacheSettings['cache_service']) && isset($cacheSettings[0], $cacheSettings[1])){
                if(is_string($cacheSettings[0]) && is_string($cacheSettings[1])){
                    if(is_object($cacheSettings[0])){
                        $factoryService = $cacheSettings[0];
                    }else{
                        $factoryService = $container->get($cacheSettings[0], ContainerInterface::NULL_ON_INVALID_REFERENCE);
                    }
                    if($factoryService){
                        if(method_exists($factoryService, $cacheSettings[0])){
                            $cacheService = $factoryService->{$cacheSettings[0]}();
                            if($cacheService instanceof CacheItemPoolInterface){
                                $this->cacheService = $cacheService;
                            }else{
                                throw new \RuntimeException('The service returned by your class factory does not implements the CacheItemPoolInterface interface');
                            }
                        }else{
                            throw new \RuntimeException('The method specified in your class factory does not exists or is not public');
                        }
                    }else{
                        throw new \RuntimeException('The specified class factory does not exists');
                    }
                }else{
                    throw new \RuntimeException('Your class factory is malformed, expected ["service_name", "public_method"] or ["@service_name", "public_method"]');
                }
            }else if(is_string($cacheSettings['cache_service'])){
                if(is_object($cacheSettings['cache_service'])){
                    $cacheService = $cacheSettings['cache_service'];
                }else{
                    $cacheService = $container->get($cacheSettings['cache_service'], ContainerInterface::NULL_ON_INVALID_REFERENCE);
                }
                if($cacheService instanceof CacheItemPoolInterface){
                    $this->cacheService = $cacheService;
                }else{
                    throw new \RuntimeException('The service returned by your class factory does not implements the CacheItemPoolInterface interface');
                }
            }
        }

        $this->swaggerBuilder = $builder;
        $this->cacheDir = $cacheDir;
    }

    /**
     * Checks whether this warmer is optional or not.
     *
     * Optional warmers can be ignored on certain conditions.
     *
     * A warmer should return true if the cache can be
     * generated incrementally and on-demand.
     *
     * @return bool true if the warmer is optional, false otherwise
     */
    public function isOptional()
    {
        return false;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        if($this->cacheService){
            $cacheItem = $this->cacheService->getItem('__swagger_json__');
            $cacheItem->set($this->swaggerBuilder->getJsonSwaggerBuild())->expiresAfter(86400);
            $this->cacheService->save($cacheItem);
        }else{
            $fs = new FileSystem();
            $fs->dumpFile($this->cacheDir . '/swagger/swagger.json', $this->swaggerBuilder->getJsonSwaggerBuild());
        }
    }
}