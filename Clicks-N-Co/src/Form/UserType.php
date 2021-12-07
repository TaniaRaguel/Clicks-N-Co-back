<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password', null, [
                'required' => false,
            ])
            ->add('lastname')
            ->add('firstname')
            ->add('phone_number')
            ->add('address')
            ->add('zip_code')
            ->add('city')
            ->add('avatar')
        ;
        $builder->get('roles')->addModelTransformer(new CallbackTransformer(

            function ($tagsAsArray) {
                // transform the array to a string
                return $tagsAsArray[0];
            },
            // La fonction qui prend la donnée du form et la transforme pour être compatible avec l'entité
            function ($tagsAsString) {
                // transform the string back to an array
                return [$tagsAsString];
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
