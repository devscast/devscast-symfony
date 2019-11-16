<?php

namespace App\Repository;

use App\Entity\Solutions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Solutions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Solutions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Solutions[]    findAll()
 * @method Solutions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolutionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Solutions::class);
    }

    // /**
    //  * @return Solutions[] Returns an array of Solutions objects
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
    public function findOneBySomeField($value): ?Solutions
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
