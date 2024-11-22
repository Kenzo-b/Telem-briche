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

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    private function orNameLike(string $keyword): void {
        $this->qb
            ->orWhere("$this->alias.name LIKE :name")
            ->setParameter('name', "%$keyword%");
    }

    private function orDescriptionLike(string $keyword): void {
        $this->qb
            ->orWhere("$this->alias.description LIKE :name")
            ->setParameter('name', "%$keyword%");
    }

    private function orPropertyLike(string $propertyName,string $keyword): void {
        $this->qb
            ->orWhere("$this->alias.$propertyName LIKE :$propertyName")
            ->setParameter($propertyName, "%$keyword%");
    }

    public function search(string $keyword): array {
        $this->initializeQueryBuilder();
        $this->orPropertyLike('description', $keyword);
        $this->orPropertyLike('name', $keyword);
        return $this->qb->getQuery()->getResult();
    }
}