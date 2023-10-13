<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VehicleRepairRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepairRepository::class)]
class VehicleRepair
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'vehicleRepair', targetEntity: VehicleToVehicleRepair::class)]
    private Collection $vehicleToVehicleRepairs;

    public function __construct()
    {
        $this->vehicleToVehicleRepairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, VehicleToVehicleRepair>
     */
    public function getVehicleToVehicleRepairs(): Collection
    {
        return $this->vehicleToVehicleRepairs;
    }

    public function addVehicleToVehicleRepair(VehicleToVehicleRepair $vehicleToVehicleRepair): self
    {
        if (!$this->vehicleToVehicleRepairs->contains($vehicleToVehicleRepair)) {
            $this->vehicleToVehicleRepairs->add($vehicleToVehicleRepair);
            $vehicleToVehicleRepair->setVehicleRepair($this);
        }

        return $this;
    }

    public function removeVehicleToVehicleRepair(VehicleToVehicleRepair $vehicleToVehicleRepair): self
    {
        if ($this->vehicleToVehicleRepairs->removeElement($vehicleToVehicleRepair)) {
            // set the owning side to null (unless already changed)
            if ($vehicleToVehicleRepair->getVehicleRepair() === $this) {
                $vehicleToVehicleRepair->setVehicleRepair(null);
            }
        }

        return $this;
    }
}
