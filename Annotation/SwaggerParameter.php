<?php

namespace Insidion\SwaggerBundle\Annotation;


use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * Class SwaggerParameter
 * @package Insidion\SwaggerBundle\Annotation
 */
class SwaggerParameter extends Annotation
{
    public $name;
    public $description = "Example description";
    public $type = "string";
    public $required = true;
}