<?php

namespace App\Entity;

class Product
{
    private ?int $id;
    private string $name;
    private ?string $description;
    private \DateTimeImmutable $createdAt;
    private ?int $quantityInStock;
    private ?float $price;
    private ?string $imageName;
}