<?php

namespace Foggyline\PaymentBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Foggyline\PaymentBundle\DependencyInjection\Compiler\OverrideServiceCompilerPass;

class FoggylinePaymentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {     
        parent::build($container);     
        $container->addCompilerPass(new  OverrideServiceCompilerPass()); 
    }
  
}