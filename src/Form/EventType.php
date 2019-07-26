<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Tour;
use App\Entity\Venue;
use App\Repository\TourRepository;
use PhpParser\Node\Stmt\Foreach_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class EventType extends AbstractType
{
    private $security;
    private $tourRepository;

    public function __construct(Security $security, TourRepository $tourRepository)
    {
        $this->security = $security;
        $this->tourRepository = $tourRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'required' => true
            ])
            ->add('tour', EntityType::class, [
                'class' => Tour::class,
                'choice_label' => 'name',
                'label' => 'Tour',
                'placeholder' => 'Select a tour',
                'required' => true,
                'choices' => $this->tourRepository->findUserTours($user)
            ])
            ->add('venue', EntityType::class, [
                'class' => Venue::class,
                'choice_label' => "name",
                'label' => "Venue",
                'placeholder' => 'Select a venue',
                'required' => false,
                'choices' => $user->getVenues(),
            ])
            ->add('beginAt', DateTimeType::class, [
                'label' => "Start Hour",
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('endAt', DateTimeType::class, [
                'label' => "End Hour",
                'widget' => 'single_text',
                'required' => true,
            ])
            /*->add('arrivalHour', DateTimeType::class, [
                'label' => "Arrival time",
                'required' => false
            ])*/
            ->add('allowance', IntegerType::class, [
                'label' => "Allowance",
                'required' => false
            ])
            /*TODO Evol
             *
             * ->add('currency', CurrencyType::class, [
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
            ])*/

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
