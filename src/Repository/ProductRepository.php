<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    private QueryBuilder $qb;

    private string $alias = 'pdt';

    private function initializeQueryBuilder(): void {
        $this->qb = $this->createQueryBuilder($this->alias)
            ->select($this->alias);
    }

    private function initializeQueryBuilderWithCount(): void {
        $this->qb = $this->createQueryBuilder($this->alias)
            ->select("COUNT($this->alias.id)");
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    private function orPropertyLike(string $propertyName,string $keyword): void {
        $this->qb
            ->orWhere("$this->alias.$propertyName LIKE :$propertyName")
            ->setParameter($propertyName, "%$keyword%");
    }

    private function searchQb(string $keyword): void {
        $this->orPropertyLike('description', $keyword);
        $this->orPropertyLike('name', $keyword);
    }

    public function search(string $keyword): array {
        $this->initializeQueryBuilder();
        $this->searchQb($keyword);
        return $this->qb->getQuery()->getResult();
    }

    public function searchCount(string $keyword): int {
        $this->initializeQueryBuilderWithCount();
        $this->searchQb($keyword);
        return $this->qb->getQuery()->getSingleScalarResult();
    }
}