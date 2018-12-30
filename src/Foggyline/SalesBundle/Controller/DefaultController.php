<?php

namespace Foggyline\SalesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FoggylineSalesBundle:Default:index.html.twig');
    }
}
