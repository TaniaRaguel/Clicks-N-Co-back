<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $generator = Faker\Factory::create('fr_FR');

    // create 20 products ! Bam!
    for ($i = 0; $i < 20; $i++) {
      $product = new Product();

      $product->setName($generator->unique()->word());
      $product->setDescription($generator->unique()->sentence($nbWords = 10, $variableNbWords = true), '.');
      $product->setUc($generator->randomElement(['Kg', 'Litres', 'Carton']));
      $product->setPrice($generator->randomFloat(2));
      $product->setPicture($generator->imageUrl(360, 360, 'Product', true));
      $product->setStock(0);
      $product->setCreatedAt(new \DateTimeImmutable());
      // récupérer le shop fixture quand ce sera fait
      // $product->setShop($shop);


      $manager->persist($product);
    }

    $manager->flush();
  }
}
