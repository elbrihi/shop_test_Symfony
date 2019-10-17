<?php

// ch_1FUaz7KllW0HmHqaOSIIkvNW

namespace Foggyline\PaymentBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Charge;

class CardController extends Controller
{
    
    public function authorizeAction(Request $request,  $amount)
    {
        
        \Stripe\Stripe::setApiKey('sk_test_FdC8ZjWifWKRqqQxfTjgHfOW00p6utRtJo');
        //print_r($_POST);
    
        //$parm = $this->getParameter('foggyline_catalog_images_directory');
        
        $token = $_POST['stripeToken'];
        
        $customer = \Stripe\Customer::create(array(
            "source" => $token
        ));
       
        // Charge Customer
        $charge = \Stripe\Charge::create(array(
            "amount" => $amount,
            "currency" => "usd",
            "description" => "Intro To React Course",
            "customer" => $customer->id
        ));
        //id
        return array('charge'=>$charge, 'customer'=> $customer);
        
    }
    public function captureAction(Request $request):Response
    {
        $transaction = md5(time() . uniqid()); // Just a dummy string, simulating some transaction id, if any
        if ($transaction) {
            return new JsonResponse(array(
                'success' => $transaction
            ));
        }
        return new JsonResponse(array(
            'error' => 'Error occurred while processing Card payment.'
        ));
    }
    public function cancelAction(Request $request):Response
    {
        $transaction = md5(time() . uniqid()); // Just a dummy string, simulating some transaction id, if any
        if ($transaction) {
            return new JsonResponse(array(
                'success' => $transaction
            ));
        }
        return new JsonResponse(array(
            'error' => 'Error occurred while processing Card payment.'
        ));
    }
}
