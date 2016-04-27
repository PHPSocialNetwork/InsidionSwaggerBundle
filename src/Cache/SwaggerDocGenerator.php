<?php

namespace Insidion\SwaggerBundle\Cache;


use Insidion\SwaggerBundle\Service\SwaggerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class SwaggerDocGenerator implements CacheWarmerInterface
{
    /* @var SwaggerBuilder $swaggerBuilder */
    private $swaggerBuilder;
    /* @var string $cacheDir **/
    private $cacheDir;

    public function __construct(SwaggerBuilder $builder, $cacheDir)
    {
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

        $fs = new FileSystem();
        $fs->dumpFile($this->cacheDir . '/swagger/swagger.json', $this->swaggerBuilder->buildSwagger());
    }
}