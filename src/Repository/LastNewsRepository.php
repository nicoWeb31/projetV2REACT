<?php

namespace App\Repository;

use App\Entity\LastNews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LastNews|null find($id, $lockMode = null, $lockVersion = null)
 * @method LastNews|null findOneBy(array $criteria, array $orderBy = null)
 * @method LastNews[]    findAll()
 * @method LastNews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LastNewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LastNews::class);
    }

    // /**
    //  * @return LastNews[] Returns an array of LastNews objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LastNews
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
