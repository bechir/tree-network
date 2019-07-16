<?php

namespace App\Repository;

use App\Entity\LinkName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LinkName|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkName|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkName[]    findAll()
 * @method LinkName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkNameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LinkName::class);
    }

    // /**
    //  * @return LinkName[] Returns an array of LinkName objects
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
    public function findOneBySomeField($value): ?LinkName
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
