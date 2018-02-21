<?php
namespace Insidion\SwaggerBundle\Tests;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class KernelBootstrap
 * @package Insidion\SwaggerBundle\Tests
 */
class KernelBootstrap extends Kernel
{
    public function registerBundles()
    {
        return [
          new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
          new \Insidion\SwaggerBundle\InsidionSwaggerBundle(),
        ];
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/../src/Resources/config/config_test.yml');
    }
}
