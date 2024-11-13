<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleEquipment;
use App\Entity\VehicleModel;
use App\Entity\VehicleRepair;
use App\Entity\VehicleSecurity;
use App\Entity\VehicleToVehicleRepair;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicle-relations')]
class VehicleRelationsController extends AbstractController
{
    #[Route('/add-one-to-one', name: 'vehicle_relations_add_one_to_one')]
    public function testAddRelationOneToOneAction(EntityManagerInterface $em): Response
    {
        $v = new Vehicle();
        $v->setPlate('EB-423-MA')->setMileage(12500)->setPrice(23000)
            ->setManufactureDate(new DateTime('2021-01-02'))->setDescription('Comme neuve');

        $vs = new VehicleSecurity();
        $vs->setAbs(true)->setEsp(false)->setAirbagNumber(4)->setEuroNcapStars(4);

        $v->setVehicleSecurity($vs); // Affectation de l'objet VehicleSecurity à l'objet propriétaire de la relation

        $em->persist($v); // Il n'est pas nécessaire de persister l'entité liée grâce à la propriété cascade
        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/update-one-to-one', name: 'vehicle_relations_update_one_to_one')]
    public function testUpdateRelationOneToOneAction(EntityManagerInterface $em): Response
    {
        // Chargement de l'entité
        $v = $em->find(Vehicle::class, 2);
        $v->setMileage(15000);
        $v->getVehicleSecurity()->setAirbagNumber(6);

        // Pas besoin de persist car Doctrine connaît les entités
        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/add-many-to-one', name: 'vehicle_relations_add_many_to_one')]
    public function testAddRelationManyToOneAction(EntityManagerInterface $em): Response
    {
        $m = new VehicleModel();
        $m->setName('3008')->setMake('Peugeot');

        $v = new Vehicle();
        $v->setVehicleModel($m)->setPlate('GA-928-GZ')
            ->setDescription('Comme neuve')->setMileage(1500)
            ->setPrice(29000)
            ->setManufactureDate(new DateTime('2021-06-02'));
        $v2 = new Vehicle();
        $v2->setVehicleModel($m)->setPlate('DK-721-MA')
            ->setDescription('Bonne occasion')->setMileage(89500)
            ->setPrice(15900)
            ->setManufactureDate(new DateTime('2017-12-21'));

        // Il faut persister les 3 entités car aucune
        // cascade n'a été définie
        $em->persist($v);
        $em->persist($v2);
        $em->persist($m);
        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/add-many-to-one-bis', name: 'vehicle_relations_add_many_to_one_bis')]
    public function testAddRelationManyToOneBisAction(EntityManagerInterface $em): Response
    {
        $m = $em->getRepository(VehicleModel::class)
            ->findOneBy(['name' => '3008']);

        $v = new Vehicle();
        $v->setVehicleModel($m)->setPlate('FV-619-NZ')
            ->setDescription('')->setMileage(46000)
            ->setPrice(16900)
            ->setManufactureDate(new DateTime('2020-01-30'));

        $em->persist($v);
        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/load-many-to-one', name: 'vehicle_relations_load_many_to_one')]
    public function testLoadRelationManyToOneAction(EntityManagerInterface $em): Response
    {
        $m = $em->getRepository(VehicleModel::class)->findOneByName('3008');
        // Remarque : findOneByName() et findByVehicleModel() n'existent pas ==> rappel : méthodes magiques
        $vehicles = $em->getRepository(Vehicle::class)->findByVehicleModel($m);
        dump($vehicles);
        // Remarque : comme la relation est bidirectionnelle, il est également possible de faire $m->getVehicles()
        return new Response('<body></body>');
    }

    #[Route('/add-many-to-many', name: 'vehicle_relations_add_many_to_many')]
    public function testAddRelationManyToManyAction(EntityManagerInterface $em): Response
    {
        // Création d'un véhicule ayant tous les équipements existants :
        $equipments = $em->getRepository(VehicleEquipment::class)->findAll();
        $vehicle = new Vehicle();
        $vehicle
            ->setPrice(6700)
            ->setPlate('AZ-529-BJ')
            ->setMileage(159000)
            ->setManufactureDate(new DateTime('2010-05-12'))
            ->setDescription('');
        foreach ($equipments as $equipment) {
            $vehicle->addEquipment($equipment);
        }
        $em->persist($vehicle);
        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/remove-many-to-many', name: 'vehicle_relations_remove_many_to_many')]
    public function testRemoveRelationManyToManyAction(EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)
            ->findOneByPlate('AZ-529-BJ');
        foreach ($vehicle->getEquipments() as $key => $equipment) {
            // Ne supprimer qu'un équipement sur 2, c'est juste pour l'exercice :)
            if ($key % 2 == 0) {
                continue;
            }
            $vehicle->removeEquipment($equipment);
        }
        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/add-many-to-many-with-attributes', name: 'vehicle_relations_add_many_to_many_with_attributes')]
    public function testAddRelationManyToManyAttributeAction(EntityManagerInterface $em): Response
    {
        // Ajout de types de réparation
        $repairs = new VehicleRepair();
        $repairs->setDescription('Forfait vidange')->setPrice(149);
        $em->persist($repairs);
        $repairs2 = new VehicleRepair();
        $repairs2->setDescription('Forfait montage / équilibrage 4 pneus')->setPrice(49);
        $em->persist($repairs2);

        // Réparations sur un véhicule existant :
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlate('AZ-529-BJ');

        // Ajout des associations
        $link = new VehicleToVehicleRepair();
        $link->setDate(new DateTime('2018-01-03'))->setVehicle($vehicle)->setVehicleRepair($repairs);
        $em->persist($link);
        $link2 = new VehicleToVehicleRepair(); // La même réparation à une autre date !
        $link2->setDate(new DateTime('2020-01-12'))->setVehicle($vehicle)->setVehicleRepair($repairs);
        $em->persist($link2);
        $link3 = new VehicleToVehicleRepair();
        $link3->setDate(new DateTime('2018-01-04'))->setVehicle($vehicle)->setVehicleRepair($repairs2);
        $em->persist($link3);

        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/many-to-many-with-attributes-test-load', name: 'vehicle_relations_many_to_many_with_attributes_test_load')]
    public function testLoadRelationsInManyToManyWithAttributesBisAction(EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlate('AZ-529-BJ');

        // Chargement de tous les VehicleToVehicleRepair associés à ce véhicule
        $links = $em->getRepository(VehicleToVehicleRepair::class)->findBy(['vehicle' => $vehicle]);

        return $this->render('vehicle/list_repairs.html.twig', ['vehicle' => $vehicle, 'links' => $links]);
    }
}
