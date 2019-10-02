<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findRecents()
    {
        return $this->createQueryBuilder('u')
            ->where('u.username is not null')
            ->orderBy('u.submittedAt', 'DESC')
            ->setMaxResults(User::NB_IMTEMS_HOME)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getUsers(int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.username is not null')
            ->orderBy('u.submittedAt', 'DESC')
        ;

        return $this->createPaginator($qb->getQuery(), $page);
    }

    /**
     * @return User[]
     */
    public function createPaginator(Query $query, int $page, $isAdmin = false): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter(($query)));
        if($isAdmin) {
            $paginator->setMaxPerPage(User::NB_ITEMS_ADMIN_LISTING);
        }else {
            $paginator->setMaxPerPage(User::NB_ITEMS_LISTING);
        }
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
