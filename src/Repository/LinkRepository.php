<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Repository;

use App\Entity\Link;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Link|null find($id, $lockMode = null, $lockVersion = null)
 * @method Link|null findOneBy(array $criteria, array $orderBy = null)
 * @method Link[]    findAll()
 * @method Link[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Link::class);
    }

    public function findRecentsByOwner(User $owner)
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.owner', 'o')
                ->addSelect('o')
            ->leftJoin('l.inverse', 'i')
                ->addSelect('i')
            ->leftJoin('l.linkCategory', 'c')
                ->addSelect('c')
            ->where('o = :owner')
            ->setParameter('owner', $owner)
            ->orderBy('i.submittedAt', 'DESC')
            ->setMaxResults(User::NB_IMTEMS_RECENT_LINKS)
            ->getQuery()
            ->getResult();
    }
}
