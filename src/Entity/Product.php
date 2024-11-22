<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'le nom du produit doit être indiqué')]
    #[Assert\Length(
        min: 5,
        max: 120,
        minMessage: "Le nom du produit doit au moin faire {{ limit }} charactères",
        maxMessage: "le nom du produit doit faire au plus {{ limit }} charactères"
    )]
    private string $name;

    #[ORM\Column(nullable: true, length: 2000)]
    #[Assert\Length(min: 10, minMessage: "Le nom du produit doit au moin faire {{ limit }} charactères")]
    private ?string $description;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(message: "La quantité doit être supérieur ou égale à zéro")]
    private ?int $quantityInStock;

    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: "le prix est obligatoire")]
    #[Assert\Positive(message: "le prix doit être strictement supérieur à zéro")]
    private ?int $price;

    #[ORM\Column(nullable: true)]
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}