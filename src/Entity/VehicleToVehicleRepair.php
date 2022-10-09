<?php

namespace App\Entity;

use App\Repository\VehicleToVehicleRepairRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleToVehicleRepairRepository::class)]
class VehicleToVehicleRepair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'vehicleToVehicleRepairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicle $vehicle = null;

    #[ORM\ManyToOne(inversedBy: 'vehicleToVehicleRepairs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VehicleRepair $vehicleRepair = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getVehicleRepair(): ?VehicleRepair
    {
        return $this->vehicleRepair;
    }

    public function setVehicleRepair(?VehicleRepair $vehicleRepair): self
    {
        $this->vehicleRepair = $vehicleRepair;

        return $this;
    }
}
