<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
         $generator = Faker\Factory::create('fr_FR');

         
       

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
        $manager->flush();
    }
}
