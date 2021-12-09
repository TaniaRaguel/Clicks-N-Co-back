<?php

namespace App\Repository;

use App\Entity\Shop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Shop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shop[]    findAll()
 * @method Shop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shop::class);
    }


/**
 * return the 5 random shops on the homepage
 *
 * @return Shop[] Returns an array of Shop objects
 */
    public function FindHomeShop ()
    {
               
        $manager = $this->getEntityManager();
        $query = $manager->createQuery(
            'SELECT shop
            FROM App\Entity\Shop shop
            ORDER BY RAND()
            '
        )
        ->setMaxResults(4);
   
    return $query->getResult();
              
        
    }

    /**
     * DQL : Doctrine Query Language
     * 
     * Retourne les villes qui correspondent à un terme de recherche
     *
     * @return void
     */
    public function findAllBySearchTermDQL($searchTerm)
    {
        // Etape 1 : On appelle le manager
        $manager = $this->getEntityManager();

        // Etape 2 : On prépare la Requete SQL
        $query = $manager->createQuery(
            'SELECT shop
             FROM App\Entity\shop shop
             WHERE shop.city LIKE :searchTerm
             

            '
        )
            // On prépare le paramètre (nettoyage de sécurité)
            ->setParameter(':searchTerm', "%$searchTerm%");

        // On execute, qui nous retourne un résultat
        return $query->getResult();
    }




    // /**
    //  * @return Shop[] Returns an array of Shop objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Shop
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
