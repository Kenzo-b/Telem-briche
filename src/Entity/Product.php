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

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): Product
    {
        $this->imageName = $imageName;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): Product
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function getQuantityInStock(): ?int
    {
        return $this->quantityInStock;
    }

    public function setQuantityInStock(?int $quantityInStock): Product
    {
        $this->quantityInStock = $quantityInStock;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): Product
    {
        $this->price = $price;
        return $this;
    }
}