<?php

namespace App\Repository;

use App\Entity\LinkCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LinkCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkCategory[]    findAll()
 * @method LinkCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LinkCategory::class);
    }

    // /**
    //  * @return LinkCategory[] Returns an array of LinkCategory objects
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
    public function findOneBySomeField($value): ?LinkCategory
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
