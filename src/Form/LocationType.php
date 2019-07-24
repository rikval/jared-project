<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('streetNumber', IntegerType::class, [
                    'label' => 'n°',
                    'required' => false
                ]
            )
            ->add('streetName', TextType::class, [
                    'label' => 'street',
                    'required' => false
                ]
            )
            ->add('city', TextType::class, [
                    'label' => 'city',
                    'required' => true
                ]
            )
            ->add('country', TextType::class, [
                    'label' => 'country',
                    'required'=> false
                ]
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
