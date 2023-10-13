<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TireRepository::class)]
class Tire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom de la marque est obligatoire')]
    #[Assert\Length(max: 64)]
    private ?string $brandName = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Range(
        notInRangeMessage: 'Le prix doit être compris entre 1€ et 1000€',
        min: 1,
        max: 1000,
    )]
    private ?float $price = null;

    #[Assert\IsTrue(message: "Le prix n'est pas valide")]
    public function isPriceValid(): bool
    {
        return is_float($this->price) && $this->price > 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(string $brandName): self
    {
        $this->brandName = $brandName;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
