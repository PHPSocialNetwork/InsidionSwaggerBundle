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
class SwaggerBuilderTest extends TestCase
{
    use SymfonyKernelTrait;

    /**
     * Builder
     */
    public function testSwaggerDefinitionBuilderServiceNotNull()
    {
        $this->assertNotNull($this->container->get('swagger.definition.builder', Container::NULL_ON_INVALID_REFERENCE));
    }

    public function testSwaggerDefinitionBuilderServiceBuildNotNull()
    {
        $this->assertNotNull($this->container->get('swagger.definition.builder', Container::NULL_ON_INVALID_REFERENCE)->getSwaggerBuild());
    }

    public function testSwaggerDefinitionBuilderServiceBuildArrayHasKey()
    {
        $this->assertArrayHasKey('info', $this->container->get('swagger.definition.builder', Container::NULL_ON_INVALID_REFERENCE)->getSwaggerBuild());
    }

    public function testSwaggerDefinitionBuilderServiceJsonBuildNotNull()
    {
        $this->assertJson($this->container->get('swagger.definition.builder', Container::NULL_ON_INVALID_REFERENCE)->getJsonSwaggerBuild());
    }
}