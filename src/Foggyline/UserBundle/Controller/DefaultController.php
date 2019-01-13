<?php

namespace Foggyline\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FoggylineUserBundle:Default:index.html.twig');
    }
}
