<?php

namespace Foggyline\ShipmentBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class FlatRateController extends Controller
{
  public function processAction(Request $request):Response
  {
    // Simulating some transaction id, if any
    $transaction = md5(time() . uniqid());
    return new JsonResponse(array(
      'success' => $transaction
    ));
  }
}







?>