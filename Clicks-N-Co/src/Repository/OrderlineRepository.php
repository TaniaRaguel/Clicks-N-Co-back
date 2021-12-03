<?php

namespace App\Repository;

use App\Entity\Orderline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Orderline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orderline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orderline[]    findAll()
 * @method Orderline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderlineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orderline::class);
    }

    // /**
    //  * @return Orderline[] Returns an array of Orderline objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Orderline
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
