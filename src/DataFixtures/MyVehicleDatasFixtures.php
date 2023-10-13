<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Vehicle;
use App\Entity\VehicleEquipment;
use App\Entity\VehicleModel;
use App\Entity\VehicleSecurity;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MyVehicleDatasFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $model = new VehicleModel();
        $model->setMake('Renault')->setName('Captur');
        $manager->persist($model);

        $model2 = new VehicleModel();
        $model2->setMake('Peugeot')->setName('508');
        $manager->persist($model2);

        $vehicleEquipment = new VehicleEquipment();
        $vehicleEquipment->setName('Climatisation')->setDescription('');
        $manager->persist($vehicleEquipment);

        $vehicleEquipment2 = new VehicleEquipment();
        $vehicleEquipment2->setName('Régulateur')->setDescription('');
        $manager->persist($vehicleEquipment2);

        $vehicleEquipment3 = new VehicleEquipment();
        $vehicleEquipment3->setName('Stop and start')->setDescription('');
        $manager->persist($vehicleEquipment3);

        $vehicleSecurity = new VehicleSecurity();
        $vehicleSecurity->setAirbagNumber(4)->setEuroNcapStars(4)->setEsp(true)->setAbs(false);
        $manager->persist($vehicleSecurity);

        $vehicle = new Vehicle();
        $vehicle->setVehicleModel($model)->setMileage(55089)->setManufactureDate(new DateTime('2016-05-06'))
            ->setPlate('BA-011-NJ')->setPrice(10500)->setDescription('Bon véhicule !')
            ->setVehicleSecurity($vehicleSecurity)->addEquipment($vehicleEquipment)->addEquipment($vehicleEquipment3);
        $manager->persist($vehicle);

        $manager->flush();
    }
}
