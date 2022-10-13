<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ORM\Table(name: 'voiture')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['plate'], message: "Il existe déjà un véhicule avec cette plaque d'immatriculation")]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, unique: true)]
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
    #[Assert\Valid]
    private ?VehicleModel $vehicleModel = null;

    #[ORM\ManyToMany(targetEntity: VehicleEquipment::class, inversedBy: 'vehicles')]
    #[ORM\JoinTable(name: 'asso_vehicle_equipment')]
    #[Assert\Valid]
    private Collection $equipments;

    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: VehicleToVehicleRepair::class)]
    private Collection $vehicleToVehicleRepairs;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
        $this->vehicleToVehicleRepairs = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function forceDescription()
    {
        if(is_null($this->description)) {
            // Uniquement si la description n'est pas renseignée, en définir une
            $this->description = "Le véhicule {$this->plate} a {$this->mileage} km";
        }
    }

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

    /**
     * @return Collection<int, VehicleEquipment>
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(VehicleEquipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments->add($equipment);
        }

        return $this;
    }

    public function removeEquipment(VehicleEquipment $equipment): self
    {
        $this->equipments->removeElement($equipment);

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
            $vehicleToVehicleRepair->setVehicle($this);
        }

        return $this;
    }

    public function removeVehicleToVehicleRepair(VehicleToVehicleRepair $vehicleToVehicleRepair): self
    {
        if ($this->vehicleToVehicleRepairs->removeElement($vehicleToVehicleRepair)) {
            // set the owning side to null (unless already changed)
            if ($vehicleToVehicleRepair->getVehicle() === $this) {
                $vehicleToVehicleRepair->setVehicle(null);
            }
        }

        return $this;
    }
}
