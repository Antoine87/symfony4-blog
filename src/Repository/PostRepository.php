<?php

namespace App\Repository;

use App\Entity\Post;
use App\Repository\Traits\Pagination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostRepository extends ServiceEntityRepository
{
    use Pagination;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findLatest(int $postsPerPage, int $page = 1): Pagerfanta
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.publishedAt <= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('p.publishedAt', 'DESC')
            ->getQuery();

        return $this->createPaginator($queryBuilder, $postsPerPage, $page);
    }
}
