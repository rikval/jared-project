<?php

namespace App\Form;

use App\Entity\Permission;
use App\Entity\Tour;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('permission', ChoiceType::class, [
                'choices' => [
                    "Administrator" => "administrator",
                    "Contributor" => "contributor"
                ],
            ])
            ->add('userTag', TextType::class, [
                'label' => 'Enter a UserTag',
                'required' => true
            ])
            ->add('tour', EntityType::class, [
                'label' => "Chose a tour",
                'class' => Tour::class,
                'choice_label' => "name"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Permission::class,
        ]);
    }
}
