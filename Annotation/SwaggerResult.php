<?php

namespace Insidion\SwaggerBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * Class SwaggerResult
 * @package Insidion\SwaggerBundle\Annotation
 */
class SwaggerResult extends Annotation
{
    public $status = 200;
    public $description = "This is an example result description";
}