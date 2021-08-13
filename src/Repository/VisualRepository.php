<?php

namespace App\Repository;

use App\Entity\Visual;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Visual|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visual|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visual[]    findAll()
 * @method Visual[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visual::class);
    }

    // /**
    //  * @return Visual[] Returns an array of Visual objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Visual
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
