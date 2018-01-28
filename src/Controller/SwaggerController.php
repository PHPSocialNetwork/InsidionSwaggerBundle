<?php

namespace Insidion\SwaggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SwaggerController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('@InsidionSwagger/Swagger/index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function jsonAction() {
        /**
         * Not a JSON response since this came from a string...
         */
        return new Response($this->get("swagger.definition.retriever")->retrieve());
    }
}
