<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Vehicle;
use App\Entity\VehicleModel;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/doctrine-events-extensions', name: 'doctrine_events_and_extensions')]
class DoctrineEventsAndExtensionsController extends AbstractController
{
    #[Route('/test-doctrine-pre-persist-event')]
    public function testDoctrineEventAction(EntityManagerInterface $em): Response
    {
        $vehicle = new Vehicle();
        $vehicle->setPlate('GA-192-FB')->setMileage(17500)->setPrice(14500)->setManufactureDate(new DateTime('2021-06-25'));
        $em->persist($vehicle);
        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/test-doctrine-service-event')]
    public function testDoctrineServiceEvent(EntityManagerInterface $em): Response
    {
        $vehicle1 = new Vehicle(); // Un véhicule sans modèle
        $vehicle1->setPlate('AA-123-BB')->setMileage(17500)->setPrice(14500)->setManufactureDate(new DateTime('2015-06-25'));

        $vehicle2 = new Vehicle(); // Un véhicule avec modèle
        $vehicle2->setPlate('BB-321-AA')->setMileage(17500)->setPrice(14500)->setManufactureDate(new DateTime('2015-06-25'));
        $model = new VehicleModel();
        $model->setName('Clio')->setMake('Renault');
        $vehicle2->setVehicleModel($model);

        $em->persist($vehicle1);
        $em->persist($vehicle2);
        $em->persist($model);
        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/test-slug')]
    public function testSlugAction(EntityManagerInterface $em): Response
    {
        $model = new VehicleModel();
        $model->setName('Mégane')->setMake('Renault');
        $em->persist($model);
        $em->flush();
        return new Response('<body></body>');
    }

    #[Route('/test-post-load')]
    public function testDoctrinePostLoadEventAction(EntityManagerInterface $em): Response
    {
        $em->getRepository(Vehicle::class)->find(1);
        $em->getRepository(Vehicle::class)->findOneBy(['plate' => 'DK-721-MA']);
        $em->getRepository(Vehicle::class)->findOneByPlate('BA-011-NJ');
        $em->getRepository(Vehicle::class)->myFind(7);
        $em->getRepository(Vehicle::class)->myFindDql(8);
        $em->getRepository(Vehicle::class)->findOneByPlateWithSecurity('EB-423-MA');
        return new Response('<body></body>');
    }
}
