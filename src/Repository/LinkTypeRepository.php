<?php

namespace App\Repository;

use App\Entity\LinkType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LinkType|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkType|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkType[]    findAll()
 * @method LinkType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LinkType::class);
    }

    // /**
    //  * @return LinkType[] Returns an array of LinkType objects
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
    public function findOneBySomeField($value): ?LinkType
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
