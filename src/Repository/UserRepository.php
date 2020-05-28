<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\Query\Expr\Join as ExprJoin;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }



    // =========================================================================
    // paginator
    // =========================================================================
    public function findAllWithPaginator():Query
    {
        return $this->createQueryBuilder('u')
        ->getQuery();
    }



    

    // =========================================================================
    // paginator and by name or pre 
    // =========================================================================
    public function findAllWithPaginatorByName($value):Query
    {
        return $this->createQueryBuilder('u')
        ->where('u.prenom LIKE :val')
        ->orWhere('u.name LIKE :val')
        ->setParameter('val', '%'.$value.'%')
        ->getQuery();
    }




    // // =========================================================================
    // // paginator and by category
    // // =========================================================================
    // public function findAllWithPaginatorByCategory($value):Query
    // {


    //     $qb = $this->createQueryBuilder('u');

    //     $qb
    //         //->innerJoin('App\Entity\CatergoryUser', 'ca', 'WITH','u.id = ca.users')
    //         ->where('u.id = :val')
    //         ->setParameter('val', $value)



    //     ;

    //     return $qb->getQuery()->getResult();
    //}






    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
