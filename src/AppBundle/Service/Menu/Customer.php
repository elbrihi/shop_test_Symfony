<?php

namespace AppBundle\Service\Menu;

class Customer {
    public function getItems() {
        return array(
            array('path' =>'account', 'label' =>'John Doe'),
            array('path' =>'logout', 'label' =>'Logout'),
        );
    }
}