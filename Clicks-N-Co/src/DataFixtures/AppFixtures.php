<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Orderline;
use Faker;
use App\Entity\Product;
use App\Entity\Shop;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $generator = Faker\Factory::create('fr_FR');


        $userEntities = array();

        $user1 = new User;
        $user1->setEmail('marc@gmail.com');
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword('$2y$13$VNfO1ajp0fqzrH6a1Kkf5OFM5dIpTTq3eQPvUnpia3J5aVn7uEExa');
        $user1->setLastname($generator->unique->lastname());
        $user1->setFirstname('Marc');
        $user1->setPhoneNumber('0644444442');
        $user1->setAddress('Rue de la Liberté');
        $user1->setZipCode('64400');
        $user1->setCity('Bayonne');
        $user1->setCitySlug('bayonne');
        $user1->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($user1);

        $user2 = new User;
        $user2->setEmail('guy@gmail.com');
        $user2->setRoles(['ROLE_TRADER']);
        $user2->setPassword('$2y$13$VNfO1ajp0fqzrH6a1Kkf5OFM5dIpTTq3eQPvUnpia3J5aVn7uEExa');
        $user2->setLastname($generator->unique->lastname());
        $user2->setFirstname('Guy');
        $user2->setPhoneNumber('0623252629');
        $user2->setAddress('Place vachement belle');
        $user2->setZipCode('75000');
        $user2->setCity('Paris');
        $user2->setCitySlug('paris');
        $user2->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($user2);

        $user3 = new User;
        $user3->setEmail('claire@gmail.com');
        $user3->setRoles(['ROLE_TRADER']);
        $user3->setPassword('$2y$13$VNfO1ajp0fqzrH6a1Kkf5OFM5dIpTTq3eQPvUnpia3J5aVn7uEExa');
        $user3->setLastname($generator->unique->lastname());
        $user3->setFirstname('Claire');
        $user3->setPhoneNumber('0614568921');
        $user3->setAddress('Impasse de la Lie');
        $user3->setZipCode('13000');
        $user3->setCity('Marseille');
        $user3->setCitySlug('marseille');
        $user3->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($user3);

        $user4 = new User;
        $user4->setEmail('john@gmail.com');
        $user4->setRoles(['ROLE_TRADER']);
        $user4->setPassword('$2y$13$VNfO1ajp0fqzrH6a1Kkf5OFM5dIpTTq3eQPvUnpia3J5aVn7uEExa');
        $user4->setLastname($generator->unique->lastname());
        $user4->setFirstname('John');
        $user4->setPhoneNumber('0459235689');
        $user4->setAddress('Rue du Soleil');
        $user4->setZipCode('69000');
        $user4->setCity('Lyon');
        $user4->setCitySlug('lyon');
        $user4->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($user4);

        $userEntities[] = [$user1, $user2, $user3, $user4];


        $shopEntities = array();

        for ($i = 1; $i < 20; $i++) {


            $shop = new shop;

            $shop->setName('la boutique de' . $generator->unique()->firstname());
            $shop->setDescription($generator->unique()->text(15));
            $shop->setpicture('shop' . $generator->numberBetween(1, 10). '.png');
            $shop->setAddress($generator->numberBetween(1, 50) . ' rue de ' . $generator->unique()->word());
            $shop->setZipCode($generator->randomElement(['60803', '70120', '56550', '07530', '64470']));
            $shop->setCity($generator->unique()->city());
            $shop->setCitySlug($generator->unique()->city());
            $shop->setEmail('john@gmail.com');
            $shop->setPhoneNumber('06 78 51 42 52');
            $shop->setOpeningHours("Ouvert du lundi au vendredi de 9h à 17h");
            $shop->setName_slug('la boutique de ' . $generator->unique()->firstname());
            $shop->setUser($generator->randomElement([$user1, $user2, $user3, $user4]));
            $shop->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($shop);
            $shopEntities[] = $shop;
        }

        $productEntities = array();

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
            $product->setShop($generator->randomElement($shopEntities));

            $productEntities[] = $product;
            
            $manager->persist($product);
        }

        
            //Create tags

            $tag1 = new Tag();

            $tag1->setname('sandwich');
            $tag1->setCreatedAt(new \DateTimeImmutable());
             
            $manager->persist($tag1);

            $tag2 = new Tag();

            $tag2->setname('vienoiserie');
            $tag2->setCreatedAt(new \DateTimeImmutable());
             
            $manager->persist($tag2);

            $tag3 = new Tag();

            $tag3->setname('riz');
            $tag3->setCreatedAt(new \DateTimeImmutable());
             
            $manager->persist($tag3);

            $tag4 = new Tag();

            $tag4->setname('pomme');
            $tag4->setCreatedAt(new \DateTimeImmutable());
             
            $manager->persist($tag4);
            

            // Create orders
        
            $orderEntities = array();
            
            for($i = 0; $i < 20; $i++) {

                $order = new Order();

                $order->setTotalPrice($generator->randomElement([20.99, 8.50, 13.60]) );
                $order->setStatus($generator->numberBetween(0,3));
                $order->setUser($generator->randomElement([$user1, $user2, $user3, $user4]));
                $order->setShop($generator->randomElement($shopEntities));
                $order->setCreatedAt(new \DateTimeImmutable());

                $orderEntities[] = $order;

                $manager->persist($order);

            }


            //Create orderlines
            $OrderlineEntities = array();

            for( $i = 0; $i < 20; $i++) {

                $orderline = new Orderline();

                $orderline->setQuantity($generator->numberBetween(1,15));
                $orderline->setPrice($generator->randomFloat(1, 1, 20));
                $orderline->setProduct($generator->randomElement($productEntities));
                $orderline->setOrderRef($generator->randomElement($orderEntities) );

                $OrderlineEntities[] = $orderline; 

                $manager->persist($orderline);   


            }

            //Create categories

          

                $category1 = new Category();
                $category1->setname('primeur');
                $category1->setpicture('category' . $generator->numberBetween(1, 10). '.png');
                $category1->setCreatedAt(new \DateTimeImmutable());

                $manager->persist($category1);


                $category2 = new Category();
                $category2->setname('restaurant');
                $category2->setpicture('category' . $generator->numberBetween(1, 10). '.png');
                $category2->setCreatedAt(new \DateTimeImmutable());

                $manager->persist($category2);



                $category3 = new Category();
                $category3->setname('boulangerie' );
                $category3->setpicture('category' . $generator->numberBetween(1, 10). '.png');
                $category3->setCreatedAt(new \DateTimeImmutable());

                $manager->persist($category3);


                $category4 = new Category();
                $category4->setname('épicerie');
                $category4->setpicture('category' . $generator->numberBetween(1, 10). '.png');
                $category4->setCreatedAt(new \DateTimeImmutable());

                $manager->persist($category4);

        $manager->flush();
    }
}
