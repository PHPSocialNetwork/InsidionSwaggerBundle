<?php

namespace Insidion\SwaggerBundle\Test;


use Insidion\SwaggerBundle\Service\SwaggerBuilder;
use Insidion\SwaggerBundle\Service\SwaggerDefinitionRetriever;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

class SwaggerDefinitionRetrieverTest extends WebTestCase
{
    public function testCallBuilderWhenNoFile () {
        $client = static::createClient();


        $builderMock = $this->getMockBuilder(SwaggerBuilder::class)->disableOriginalConstructor()->getMock();
        $builderMock->expects($this->once())
            ->method('buildSwagger')
            ->willReturn("built_swagger");
        $client->getContainer()->set('swagger.definition.builder', $builderMock);

        $fsMock = $this->getMockBuilder(FileSystem::class)->disableOriginalConstructor()->getMock();
        $fsMock->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $retriever = new SwaggerDefinitionRetriever($client->getContainer(), '', $fsMock);

        $this->assertEquals('built_swagger', $retriever->retrieve());
    }
}