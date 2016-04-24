<?php

namespace Insidion\SwaggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('InsidionSwaggerBundle:Default:index.html.twig');
    }
}
