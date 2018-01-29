<?php

namespace Insidion\SwaggerBundle\Annotation;


use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 */
class Swagger extends Annotation
{
    public $showInDocs = true;
    public $operationId;
    public $description = '';
    public $summary;
    public $security = [];
    public $tags;
    public $consumes = array("application/json");
    public $produces = array("application/json");
    public $deprecated = false;
}