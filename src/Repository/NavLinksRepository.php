<?php

namespace App\Repository;

use App\Entity\NavLinks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NavLinks|null find($id, $lockMode = null, $lockVersion = null)
 * @method NavLinks|null findOneBy(array $criteria, array $orderBy = null)
 * @method NavLinks[]    findAll()
 * @method NavLinks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavLinksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NavLinks::class);
    }

    // /**
    //  * @return NavLinks[] Returns an array of NavLinks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NavLinks
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
