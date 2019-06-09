<?php

namespace Foggyline\PaymentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CardType extends AbstractType
{
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
               ->add('cardType')
               ->add('cardNumber', TextType::class,
                    array(
                        'attr'=>array(
                                    'class'=>'number credit-card-number form-control',
                                    'inputmode'=>'numeric',
                                    'autocomplete'=>'cc-number',
                                    'autocompletetype'=>'cc-number',
                                    'x-autocompletetype'=>'cc-number',
                                    'placeholder'=>'&#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149;',
                            )
                    )
               )
               ->add('securityCode', TextType::class,
                    array(
                        'attr'=>array(
                                    'class'=>'security-code form-control',
                                    'Â· inputmode'=>'numeric',
                                    'placeholder'=>"&#149;&#149;&#149;",
                            )
                    )
               )
               ->add('expirtyDate', TextType::class,
                    array(
                        'attr'=>array(
                                    'class'=>'expiration-month-and-year form-control',
                                    'Â· inputmode'=>'numeric',
                                    'placeholder'=>"MM / YY",
                            )
                    )
                );
               
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Foggyline\PaymentBundle\Entity\Card'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'foggyline_paymentbundle_card';
    }


}
