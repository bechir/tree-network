<?php

namespace App\Repository;

use App\Entity\BirthPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BirthPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method BirthPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method BirthPlace[]    findAll()
 * @method BirthPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BirthPlaceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BirthPlace::class);
    }

    // /**
    //  * @return BirthPlace[] Returns an array of BirthPlace objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BirthPlace
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
