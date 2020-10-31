<?php

namespace App\Repository;

use App\Entity\AdminBookings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminBookings|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminBookings|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminBookings[]    findAll()
 * @method AdminBookings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminBookingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminBookings::class);
    }

    // /**
    //  * @return AdminBookings[] Returns an array of AdminBookings objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdminBookings
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
