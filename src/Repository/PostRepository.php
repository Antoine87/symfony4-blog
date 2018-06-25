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

    public function findLatestPaginated(int $postsPerPage, int $page = 1): Pagerfanta
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p, a
                FROM App:Post p
                LEFT JOIN p.author a
                WHERE p.publishedAt <= :now
                ORDER BY p.publishedAt DESC
            ')
            ->setParameter('now', new \DateTime());

        return $this->createPaginator($query, $postsPerPage, $page);
    }

    public function findAllWithAuthors()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p, a
                FROM App:Post p
                LEFT JOIN p.author a
            ');

        return $query->getResult();
    }
}
