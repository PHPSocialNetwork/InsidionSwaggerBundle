<?php

namespace Insidion\SwaggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SwaggerController extends Controller
{
    public function indexAction()
    {
        return $this->render('InsidionSwaggerBundle:Default:index.html.twig');
    }

    public function jsonAction() {
        return new Response($this->get("swagger.definition.retriever")->retrieve());
    }
}
