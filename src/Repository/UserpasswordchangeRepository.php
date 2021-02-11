<?php

namespace App\Repository;

use App\Entity\Userpasswordchange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Userpasswordchange|null find($id, $lockMode = null, $lockVersion = null)
 * @method Userpasswordchange|null findOneBy(array $criteria, array $orderBy = null)
 * @method Userpasswordchange[]    findAll()
 * @method Userpasswordchange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserpasswordchangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Userpasswordchange::class);
    }

    // /**
    //  * @return Userpasswordchange[] Returns an array of Userpasswordchange objects
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
    public function findOneBySomeField($value): ?Userpasswordchange
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
