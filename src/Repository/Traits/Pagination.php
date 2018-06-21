<?php

namespace App\Repository\Traits;

use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

trait Pagination
{
    private function createPaginator(Query $query, int $itemsPerPage, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage($itemsPerPage);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
