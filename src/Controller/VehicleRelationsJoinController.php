<?php

namespace App\Controller;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicle-relations-join', name: 'vehicle_relations_join_')]
class VehicleRelationsJoinController extends AbstractController
{
    #[Route('/one-to-one-no-join', name: 'one_to_one_no_join')]
    public function testOneToOneNoJoinAction(EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlate('EB-423-MA');
        // Le fait d'accéder à une propriété de l'entité VehicleSecurity déclenche la seconde requête
        dump($vehicle->getVehicleSecurity()->getAirbagNumber());
        return new Response('<body></body>');
    }

    #[Route('/one-to-one-with-join', name: 'one_to_one_with_join')]
    public function testOneToOneWithJoinAction(EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlateWithSecurity('EB-423-MA');
        // Cette fois-ci, Doctrine n'a pas besoin d'exécuter une seconde requête car
        // il "connaît" les données de VehicleSecurity
        dump($vehicle->getVehicleSecurity()->getAirbagNumber());
        return new Response('<body></body>');
    }

    #[Route('/one-to-one-with-join-and-join-condition', name: 'one_to_one_with_join_and_join_condition')]
    public function testOneToOneWithJoinAndJoinConditionAction(EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlateWithSecurityAnd4Stars('EB-423-MA');
        dump($vehicle->getVehicleSecurity()->getAirbagNumber());
        return new Response('<body></body>');
    }

    #[Route('/many-to-one-no-join', name: 'many_to_one_no_join')]
    public function testManyToOneNoJoinAction(EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlate('GA-928-GZ');
        // Le fait d'accéder à une propriété de l'entité VehicleModel déclenche la seconde requête
        dump($vehicle->getVehicleModel()->getName());
        return new Response('<body></body>');
    }

    #[Route('/many-to-one-with-join', name: 'many_to_one_with_join')]
    public function testManyToOneWithJoinAction(EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlateWithModel('GA-928-GZ');
        // Cette fois-ci, Doctrine n'a pas besoin d'exécuter une seconde requête car
        // il "connaît" les données de VehicleModel
        dump($vehicle->getVehicleModel()->getName());
        return new Response('<body></body>');
    }

}
