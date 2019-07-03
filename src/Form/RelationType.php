<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Contact;
use App\Entity\Relation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('affinity', ChoiceType::class, [
                'choices' => [
                    "Like" => "like",
                    "Doesn't like" => 'unlike'
                ],
            ])
            ->add('note', TextareaType::class, [
                'label' => "Note",
                'required' => false
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => "name"
            ])
            ->add('contact', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => "name"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Relation::class,
        ]);
    }
}
