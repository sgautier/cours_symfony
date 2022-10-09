<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ORM\Table(name: 'voiture')]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $plate = null;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'manu_date', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $manufactureDate = null;

    #[ORM\OneToOne(inversedBy: 'vehicle', cascade: ['persist', 'remove'])]
    private ?VehicleSecurity $vehicleSecurity = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?VehicleModel $vehicleModel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlate(): ?string
    {
        return $this->plate;
    }

    public function setPlate(string $plate): self
    {
        $this->plate = $plate;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getManufactureDate(): ?\DateTimeInterface
    {
        return $this->manufactureDate;
    }

    public function setManufactureDate(\DateTimeInterface $manufactureDate): self
    {
        $this->manufactureDate = $manufactureDate;

        return $this;
    }

    public function getVehicleSecurity(): ?VehicleSecurity
    {
        return $this->vehicleSecurity;
    }

    public function setVehicleSecurity(?VehicleSecurity $vehicleSecurity): self
    {
        $this->vehicleSecurity = $vehicleSecurity;

        return $this;
    }

    public function getVehicleModel(): ?VehicleModel
    {
        return $this->vehicleModel;
    }

    public function setVehicleModel(?VehicleModel $vehicleModel): self
    {
        $this->vehicleModel = $vehicleModel;

        return $this;
    }
}
