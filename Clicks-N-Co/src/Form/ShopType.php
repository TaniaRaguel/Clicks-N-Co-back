<?php

namespace App\Form;

use App\Entity\Shop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ShopType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('description', TextareaType::class, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('picture', FileType::class, [
        'mapped' => false,
        'required' => false,
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

      ->add('email', EmailType::class, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('phone_number', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('opening_hours', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('categories', null, [
        'expanded' => true,
        'multiple' => true,
        'required' => false,
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Shop::class,
    ]);
  }
}
