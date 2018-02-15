<?php

namespace Insidion\SwaggerBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class SwaggerDefinitionRetriever
{
    /** @var ContainerInterface $container */
    private $container;
    private $cacheDir;
    /** @var Filesystem $fileSystem */
    private $fileSystem;

    public function __construct(ContainerInterface $container, $cacheDir, Filesystem $fileSystem)
    {
        $this->container = $container;
        $this->cacheDir = $cacheDir;
        $this->fileSystem = $fileSystem;
    }

    /**
     * Retrieves the swagger json. Either from the filesystem (in case cache has been enabled), or produced on the fly.
     * @return string
     */
    public function retrieve() {
        $filePath = $this->cacheDir . "/swagger/swagger.json";
        if($this->fileSystem->exists($filePath)) {
            return file_get_contents($filePath);
        } else {
            return $this->container->get('swagger.definition.builder')->getJsonSwaggerBuild();
        }
    }
}