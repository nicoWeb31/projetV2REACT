<?php

namespace App\Repository;

use App\Entity\CatergoryUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CatergoryUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatergoryUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatergoryUser[]    findAll()
 * @method CatergoryUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatergoryUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatergoryUser::class);
    }

    // /**
    //  * @return CatergoryUser[] Returns an array of CatergoryUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CatergoryUser
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
