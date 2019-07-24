<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Name",
                'required' => true

            ])
            ->add('email', EmailType::class, [
                'label' => "Mail",
                'required' => false
            ])
            ->add('phone', TelType::class, [
                'label' => "Phone",
                'required' => false
            ])
            ->add('website', UrlType::class, [
                'label' => "Website",
                'required' => false
            ])
            ->add('language', LanguageType::class, [
                'label' => "Language",
                'required' => false
            ])
            ->add('note', TextareaType::class, [
                'label' => "Note",
                'required' => false
            ])
            ->add('location', LocationType::class, [
                'label' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
