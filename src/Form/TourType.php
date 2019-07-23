<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Tour;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Tour name',
                'required' => true
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
                'label' => 'Artist',
                'placeholder' => 'Choose an artist',
                'required' => true
            ])
            ->add('startDate', DateType::class, [
                'label' => "Begin date",
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('endDate', DateType::class, [
                'label' => "End date",
                'widget' => "single_text",
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tour::class,
        ]);
    }
}
