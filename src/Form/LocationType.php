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
            ->add('streetNumber',
                IntegerType::class,
                [
                    'label' => 'N°'
                ]
            )
            ->add('streetName',
                TextType::class,
                [
                    'label' => 'Rue'
                ]
            )
            ->add('city',
                TextType::class,
                [
                    'label' => 'Ville'
                ]
            )
            ->add('country',
                CountryType::class,
                [
                    'label' => 'Pays'
                ]
            )
            ->add('longitude',
                NumberType::class,
                [
                    'label' => 'Longitude'
                ]
            )
            ->add('latitude',
                NumberType::class,
                [
                    'label' => 'Latitude'
                ]
            )
            ->add('zip',
                TextType::class,
                [
                    'label' => 'ZIP'
                ]
            )

            //TODO : Venue
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
