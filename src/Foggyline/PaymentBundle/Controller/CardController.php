<?php

namespace Foggyline\PaymentBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CardController extends Controller
{
    public function authorizeAction(Request $request):Response
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
