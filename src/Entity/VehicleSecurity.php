<?php

namespace App\Entity;

use App\Repository\VehicleSecurityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleSecurityRepository::class)]
class VehicleSecurity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $euroNcapStars = null;

    #[ORM\Column]
    private ?int $airbagNumber = null;

    #[ORM\Column]
    private ?bool $abs = null;

    #[ORM\Column]
    private ?bool $esp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEuroNcapStars(): ?int
    {
        return $this->euroNcapStars;
    }

    public function setEuroNcapStars(int $euroNcapStars): self
    {
        $this->euroNcapStars = $euroNcapStars;

        return $this;
    }

    public function getAirbagNumber(): ?int
    {
        return $this->airbagNumber;
    }

    public function setAirbagNumber(int $airbagNumber): self
    {
        $this->airbagNumber = $airbagNumber;

        return $this;
    }

    public function isAbs(): ?bool
    {
        return $this->abs;
    }

    public function setAbs(bool $abs): self
    {
        $this->abs = $abs;

        return $this;
    }

    public function isEsp(): ?bool
    {
        return $this->esp;
    }

    public function setEsp(bool $esp): self
    {
        $this->esp = $esp;

        return $this;
    }
}
