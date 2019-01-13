<?php

namespace Foggyline\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Foggyline\UserBundle\Form\ChoiceType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username',TextType::class)
                ->add('email',EmailType::class)
                ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                 ))
                 ->add('roles',ChoiceType::class,array(
                                        'multiple'=>true,
                                        'expanded'=> true,
                                                'choices'=>array(
                                                        'Creator'=>'ROLE_CREATOR',
                                                        'Moderator' => 'ROLE_MODERATOR',
                                                        'Admin' => 'ROLE_ADMIN',
                                                       )
                 ))
                 ->add('submit', SubmitType::class,array(
                     'attr'=>array(
                         'btn btn-success pull-right'
                           )
                 ));
                
          
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Foggyline\UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'foggyline_userbundle_user';
    }


}
