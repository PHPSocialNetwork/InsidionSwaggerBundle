<?php
/*
 * This file is part of the InsidionSwaggerBundle
 *
 * (c) Georges.L <contact@geolim4.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Insidion\SwaggerBundle\Tests\Service;

use Insidion\SwaggerBundle\Tests\SymfonyKernelTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;

/**
 * SwaggerBuilderTest.
 *
 * @author Georges.L <contact@geolim4.com>
 */
class RoutingProcessorTest extends TestCase
{
    use SymfonyKernelTrait;

    /**
     * Builder
     */
    public function testSwaggerDefinitionBuilderServiceNotNull()
    {
        $this->assertNotNull($this->container->get('swagger.processor.routing', Container::NULL_ON_INVALID_REFERENCE));
    }

    public function testSwaggerDefinitionBuilderServiceBuildNotNull()
    {
        $this->assertNotNull($this->container->get('swagger.processor.routing', Container::NULL_ON_INVALID_REFERENCE)->process());
    }
}