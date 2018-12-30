<?php

namespace Foggyline\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FoggylinePaymentBundle:Default:index.html.twig');
    }
}
