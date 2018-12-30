<?php 

namespace Foggyline\ShipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use  Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
class DynamicRateController extends Controller
{ 
    public function processAction(Request $request):Response
    {
        $transaction = md5(time() . uniqid()); // Just a dummy string, simulating some transaction id, if any
        if ($transaction) {
            return new JsonResponse(array(
                'success' => $transaction
            ));
        }
        return new JsonResponse(array(
            'error' => 'Error occurred while processing DynamicRate shipment.'
        ));
    }
}




?>