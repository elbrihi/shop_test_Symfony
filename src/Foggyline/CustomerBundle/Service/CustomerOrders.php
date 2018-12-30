<?php

namespace Foggyline\CustomerBundle\Service;

class CustomerOrders
{
    public function getOrders()
    {
        return array(
                array(
            'id' => '000001',
            'date' => '23/06/2016 18:45',
            'ship' => 'John Doe',
            'orderTotal' => '49.99',
            'statut' => 'Processing',
            'action' =>array
                        (
                          array( 
                              'lebel'=>'Cancel',
                               'path'=> '#'
                            ),
                            array('lebel'=>'Print',
                                   'path'=> '#'),
                            )
            )
        );
    }
}




?>