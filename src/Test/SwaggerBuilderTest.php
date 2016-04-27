<?php

namespace Insidion\SwaggerBundle\Test\Service;


use Insidion\SwaggerBundle\Processor\RoutingProcessor;
use Insidion\SwaggerBundle\Processor\SchemaProcessor;
use Insidion\SwaggerBundle\Service\SwaggerBuilder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SwaggerBuilderTest extends WebTestCase
{
    public function testCreate() {
        $swaggerBuilder = new SwaggerBuilder(array("test_property" => "test"), $this->getRoutingMock(), $this->getSchemaMock());
        $result = $swaggerBuilder->buildSwagger();
        $this->assertEquals("{\"test_property\":\"test\",\"swagger\":\"2.0\",\"paths\":{\"test\":\"test-result\"},\"definitions\":{\"Address\":{\"type\":\"string\"}}}", $result);
    }

    private function getRoutingMock() {
        $routingMock = $this->getMockBuilder(RoutingProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $routingMock
            ->expects($this->once())
            ->method("process")
            ->will($this->returnValue(array("test" => "test-result")));

        return $routingMock;
    }

    private function getSchemaMock() {
        $schemaMock = $this->getMockBuilder(SchemaProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $schemaMock
            ->expects($this->once())
            ->method("process")
            ->will($this->returnValue(
                array(
                    "Address" => array(
                        "type" => "string"
                    )
                )
            ));

        return $schemaMock;

    }
}