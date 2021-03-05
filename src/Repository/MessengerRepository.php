<?php

namespace App\Repository;

use App\Entity\Messenger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Messenger|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messenger|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messenger[]    findAll()
 * @method Messenger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessengerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messenger::class);
    }

    // /**
    //  * @return Messenger[] Returns an array of Messenger objects
    //  */

    public function findByidexp($value,$val2)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('(m.id_exp = :val and m.id_recp =:val2) ')
            ->orWhere('(m.id_exp = :val2 and m.id_recp =:val)')
            ->setParameter('val', $value)
            ->setParameter('val2', $val2)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Messenger
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
