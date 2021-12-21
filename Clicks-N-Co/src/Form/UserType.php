<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class UserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email', EmailType::class, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      // ->add('roles')
      ->add('password', PasswordType::class, [
        'constraints' => new NotBlank,
      ])
      ->add('lastname', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('firstname', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('phone_number', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('address', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('zip_code', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('city', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('avatar', FileType::class, [
        'mapped' => false,
        'required' => false,
      ]);
    // $builder->get('roles')->addModelTransformer(new CallbackTransformer(

    //   function ($tagsAsArray) {
    //     // transform the array to a string
    //     return $tagsAsArray[0];
    //   },
    //   // La fonction qui prend la donnée du form et la transforme pour être compatible avec l'entité
    //   function ($tagsAsString) {
    //     // transform the string back to an array
    //     return [$tagsAsString];
    //   }
    // ));
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
