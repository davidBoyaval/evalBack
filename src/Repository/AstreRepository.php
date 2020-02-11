<?php

namespace App\Repository;

use App\Entity\Astre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Astre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Astre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Astre[]    findAll()
 * @method Astre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AstreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Astre::class);
    }

    // /**
    //  * @return Astre[] Returns an array of Astre objects
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
    public function findOneBySomeField($value): ?Astre
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
