<?php

namespace App\Repository;

use App\Entity\EscapeGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EscapeGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method EscapeGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method EscapeGame[]    findAll()
 * @method EscapeGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EscapeGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EscapeGame::class);
    }

    // /**
    //  * @return EscapeGame[] Returns an array of EscapeGame objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EscapeGame
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
