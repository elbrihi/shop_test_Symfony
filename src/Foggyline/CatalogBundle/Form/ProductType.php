<?php

namespace Foggyline\CatalogBundle\Form;

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
use Symfony\Component\Form\Extension\Core\Type\ FileType;



class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title',TextType::class, array(
                    'attr'=>array(
                        'class'=>'form-control',
                    )
                )
                )
                ->add('price',TextType::class, array(
                    'attr'=>array(
                        'class'=>'form-control',
                    )
                  )
                )
                ->add('sku',TextType::class, array(
                    'attr'=>array(
                        'class'=>'form-control',
                    )
                )
                )
                ->add('urlSku',TextType::class, array(
                    'attr'=>array(
                        'class'=>'form-control',
                    )
                ))
                ->add('description',TextType::class, array(
                    'attr'=>array(
                        'class'=>'form-control',
                    )
                )
                )
                ->add('qty',TextType::class, array(
                    'attr'=>array(
                        'class'=>'form-control',
                    )
                )
                )
                ->add('category'
                )
              
                ->add('image',FileType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Foggyline\CatalogBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'foggyline_catalogbundle_product';
    }


}
