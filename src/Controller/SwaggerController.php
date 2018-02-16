<?php

namespace Insidion\SwaggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        return new JsonResponse(
          $this->get("swagger.definition.builder")->getSwaggerBuild(),
          Response::HTTP_OK
        );
    }
}
