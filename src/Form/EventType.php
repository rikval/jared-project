<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Venue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('dateEvent', DateType::class, [
                'label' => 'Date du concert',
                'format' => 'dd-MM-yyyy',
                'widget' => 'choice'
            ])
            ->add('startHour', TimeType::class, [
                'label' => 'Heure de début',
                'widget' => 'choice'
            ])
            ->add('endHour', TimeType::class, [
                'label' => "Heure de fin",
                'widget' => 'choice'
            ])
            ->add('arrivalHour', TimeType::class, [
                'label' => "Heure d'arrivée",
                'widget' => 'choice'
            ])
            ->add('allowance', IntegerType::class, [
                'label' => "Cachet"
            ])
            ->add('currency', TextType::class, [
                'label' => "Devise"
            ])
            ->add('hasAccommodation', CheckboxType::class, [
                'label' => "Hébergement prévu ?",
                'required' => false
            ])
            ->add('isPublic', CheckboxType::class, [
                'label' => "Voulez-vous rendre cette événement public ?",
                'required' => false
            ])
            ->add('venue', EntityType::class, [
                'class' => Venue::class,
                'label' => "Venue",
                'choice_label' => "name"
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
