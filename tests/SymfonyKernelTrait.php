<?php
/*
 * This file is part of the InsidionSwaggerBundle
 *
 * (c) Georges.L <contact@geolim4.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Insidion\SwaggerBundle\Tests;

use Insidion\SwaggerBundle\Tests\KernelBootstrap;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Kernel;

trait SymfonyKernelTrait
{
    /**
     * @var Kernel
     */
    protected $kernel;
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @before
     */
    protected function setUpSymfonyKernel()
    {
        $this->kernel = $this->createKernel();
        $this->kernel->boot();
        $this->container = $this->kernel->getContainer();
    }

    protected function createKernel()
    {
        $class = $this->getKernelClass();
        $options = $this->getKernelOptions();
        return new $class(
          isset($options[ 'environment' ]) ? $options[ 'environment' ] : 'test',
          isset($options[ 'debug' ]) ? $options[ 'debug' ] : true
        );
    }

    protected function getKernelClass()
    {
        return KernelBootstrap::class;
    }

    protected function getKernelOptions()
    {
        return ['environment' => 'test', 'debug' => true];
    }

    /**
     * @after
     */
    protected function tearDownSymfonyKernel()
    {
        if (null !== $this->kernel) {
            $this->kernel->shutdown();
        }
    }
}