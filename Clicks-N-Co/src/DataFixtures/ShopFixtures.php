<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
         // On crée une instance de Faker en français
         $generator = Faker\Factory::create('fr_FR');

        $shopEntities = array();

               
        for ($i = 1; $i < 20; $i++) {


            $shop = new shop;

            $shop->setName('la boutique de' .$generator->unique()->firstname()  );
            $shop->setDescription($generator->unique()->text(15));
            $shop->setpicture('shop'. $generator->numberBetween(1,20));
            $shop->setAddress($generator-> numberBetween(1,50). 'rue de'. $generator->unique()->word() );
            $shop->setZipCode($generator->randomElement(['60803', '70120', '56550', '07530', '64470']));
            $shop->setCity($generator->unique()->city());
            $shop->setCitySlug($generator->unique()->city());
            $shop->setEmail($generator->randomElement(['60803', '70120', '56550', '07530', '64470']));
            $shop->setPhoneNumber('06'. $generator>shuffle([1, 2, 3, 4, 5, 6, 7, 8]));
            $shop->setOpeningHours("Ouvert du lundi au vendredi de 9h à 17h");
            $shop->setName_slug('la boutique de' .$generator->unique()->firstname()  );


        //SHOP: code_shop, name, description, picture, address, zip_code, city, city_slug, email, phone_number, opening_hours, name_slug

            
        }


        $manager->flush();
    }
}
