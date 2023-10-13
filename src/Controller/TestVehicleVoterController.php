<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/test-vehicle-voter', name: 'test_vehicle_voter_')]
class TestVehicleVoterController extends AbstractController
{
    #[Route('/view', name: 'view')]
    public function viewAction(Security $security, EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlate('GC-546-AA');

        if (!$vehicle || !$security->isGranted('view', $vehicle)) {
            throw new NotFoundHttpException('Véhicule inconnu');
        }

        return $this->render('text_vehicle_voter.html.twig', ['vehicle' => $vehicle]);
    }

    #[Route('/view-empty', name: 'view_empty')]
    public function viewEmptyAction(Security $security, EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlate('GC-546-AA');
        if (!$vehicle) {
            throw new NotFoundHttpException('Véhicule inconnu');
        }
        $vehicle->setPlate(''); // Pour le test, on vide l'immatriculation

        if (!$security->isGranted('view', $vehicle)) {
            throw new NotFoundHttpException('Véhicule inconnu');
        }

        return $this->render('text_vehicle_voter.html.twig', ['vehicle' => $vehicle]);
    }

    #[Route('/edit', name: 'edit')]
    public function editAction(Security $security, EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlate('GC-546-AA');

        if (!$vehicle || !$security->isGranted('edit', $vehicle)) {
            throw new NotFoundHttpException("Vous n'avez pas le droit d'éditer ce véhicule");
        }

        return new Response('<body>Vous avez le droit :-)</body>');
    }
}
