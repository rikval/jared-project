<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Tour;
use App\Entity\Venue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('tour', EntityType::class, [
                'class' => Tour::class,
                'choice_label' => 'name',
                'label' => 'Select a tour',
            ])
            ->add('beginAt')
            ->add('endAt')
            ->add('arrivalHour', TimeType::class, [
                'label' => "arrival time",
                'widget' => 'choice',
                'required' => false
            ])
            ->add('allowance', IntegerType::class, [
                'label' => "allowance",
                'required' => false
            ])
            ->add('currency', CurrencyType::class, [
                'label' => "currency",
                'required' => false
            ])
            ->add('hasAccommodation', CheckboxType::class, [
                'label' => "is there any accommodation ",
                'required' => false
            ])
            ->add('isPublic', CheckboxType::class, [
                'label' => "do you want to give a public visibility to this event  ?",
                'required' => false
            ])
            ->add('venue', EntityType::class, [
                'class' => Venue::class,
                'label' => "venue",
                'choice_label' => "name",
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
