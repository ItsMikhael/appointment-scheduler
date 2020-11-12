<?php

namespace App\Repository;

use App\Entity\AdminAvailability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdminAvailability|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminAvailability|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdminAvailability[]    findAll()
 * @method AdminAvailability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminAvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminAvailability::class);
    }

    // /**
    //  * @return AdminAvailability[] Returns an array of AdminAvailability objects
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
    public function findOneBySomeField($value): ?AdminAvailability
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
