<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('name', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('description', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('uc', null, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('price', MoneyType::class, [
        'constraints' => [
          new NotBlank(),
        ]
      ])
      ->add('picture', FileType::class, [
        'mapped' => false,
        'required' => false,
      ])
      ->add('stock')
      ->add('tags', null, [
        'expanded' => true,
        'multiple' => true,
        'required' => false,
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Product::class,
    ]);
  }
}
