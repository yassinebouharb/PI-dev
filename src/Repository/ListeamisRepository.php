<?php

namespace App\Repository;

use App\Entity\Listeamis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Listeamis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Listeamis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Listeamis[]    findAll()
 * @method Listeamis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeamisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Listeamis::class);
    }

    // /**
    //  * @return Listeamis[] Returns an array of Listeamis objects
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
    public function findOneBySomeField($value): ?Listeamis
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
