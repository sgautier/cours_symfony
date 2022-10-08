<?php

namespace App\Controller;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicle')]
class VehicleController extends AbstractController
{
    #[Route('/add', name: 'vehicle_add')]
    public function addAction(EntityManagerInterface $entityManager): Response
    {
        $vehicle = new Vehicle();
        $vehicle->setPlate('AB-123-CD')->setMileage(58000)->setPrice(19999.99)
            ->setManufactureDate(new \DateTime('2017-11-24'))->setDescription('Très belle voiture');

        // Dire à Doctrine qu'a priori l'objet devra être sauvegardé en base de données (pas de requête pour le moment)
        $entityManager->persist($vehicle);

        // Exécute réellement la(les) requête(s) => INSERT, UPDATE, ...
        $entityManager->flush();

        return new Response("<body>Nouveau véhicule créé avec l'ID : {$vehicle->getId()}" . '</body>');
    }

    #[Route('/test-entity-manager', name: 'vehicle_test_entity_manager')]
    public function testEntityManagerAction(EntityManagerInterface $entityManager): Response
    {
        $vehicle = new Vehicle();
        $vehicle->setPlate('AB-123-CD')->setMileage(58000)->setPrice(19999.99)
            ->setManufactureDate(new \DateTime('2017-11-24'))->setDescription('Très belle voiture');
        $vehicle2 = clone($vehicle);
        $entityManager->persist($vehicle);

        if($entityManager->contains($vehicle)) { /* true */ dump('$vehicle1 est connu'); }
        if($entityManager->contains($vehicle2)) { /* false */ dump('$vehicle2 est connu'); }
        $entityManager->clear('App\Entity\Vehicle'); // Toutes les entités Vehicle ne seront plus persistées
        $entityManager->clear(); // Plus aucune entité ne sera persistée (tout type confondu)

        $entityManager->persist($vehicle2);
        $entityManager->flush();

        $vehicle2->setPlate('BA-321-DC');
        dump($vehicle2);
        $entityManager->refresh($vehicle2); // $vehicle2 est rechargé avec ses données en base
        dump($vehicle2);
        $entityManager->remove($vehicle2); // Supprimera $vehicle2 au prochain flush()
        $entityManager->flush();

        return new Response('<body>Aucun changement dans la base de données :)</body>');
    }

}
