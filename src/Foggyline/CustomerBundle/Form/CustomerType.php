<?php

namespace Foggyline\CustomerBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class CustomerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email')
            ->add('username')
            //->add('password')
            ->add('plainPassword',RepeatedType::class, array(
                'type'=> PasswordType::class,
                'first_options' => array('label'=>'Password'),
                'second_options' => array('label'=>'Repeat Password'),
            ))
            ->add('firstName')
            ->add('lastName')
            ->add('comapany')
            ->add('phoneNumber')
            ->add('country')
            ->add('state')
            ->add('city')
            ->add('postcode')
            ->add('street');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Foggyline\CustomerBundle\Entity\Customer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'foggyline_customerbundle_customer';
    }


}
