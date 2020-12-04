<?php
namespace App\Controller;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller
 * @Route("/vehicle")
 */
class VehicleController extends AbstractController
{
    /**
     * @Route("/add", name="vehicle_add")
     */
    public function addAction()
    {
        // you can fetch the EntityManager via $this->getDoctrine() or $this->get('doctrine')
        // or you can add an argument to your action: index(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $vehicle = new Vehicle();
        $vehicle->setPlate('AB-123-CD')->setMileage(58000)->setPrice(19999.99)
            ->setManufactureDate(new \DateTime('2017-11-24'))->setDescription('Très belle voiture');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($vehicle);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('<body>Saved new vehicle with id ' . $vehicle->getId() . '</body>');
    }

    /**
     * @Route("/test-entity-manager", name="vehicle_test_entity_manager")
     */
    public function testEntityManagerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $vehicle = new Vehicle();
        $vehicle->setPlate('AB-123-CD')->setMileage(58000)->setPrice(19999.99)
            ->setManufactureDate(new \DateTime('2017-11-24'))->setDescription('Très belle voiture');
        $vehicle2 = clone($vehicle);
        $em->persist($vehicle);

        if($em->contains($vehicle)) { /* true */ dump('$vehicle1 est connu'); }
        if($em->contains($vehicle2)) { /* false */ dump('$vehicle2 est connu'); }
        $em->clear('App\Entity\Vehicle'); // Toutes les entités Vehicle ne seront plus persistées
        $em->clear(); // Plus aucune entité ne sera persistée (tout type confondu)

        $em->persist($vehicle2);
        $em->flush();

        $vehicle2->setPlate('BA-321-DC');
        dump($vehicle2);
        $em->refresh($vehicle2); // $vehicle2 est rechargé avec ses données en base
        dump($vehicle2);
        $em->remove($vehicle2); // Supprimera $vehicle2 au prochain flush()
        $em->flush();

        return new Response('<body>Aucun changement dans la base de données :)</body>');
    }

    /**
     * @Route("/show/{id}", name="vehicle_show")
     * @param $id
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function showAction($id, EntityManagerInterface $em)
    {
        // Préciser l'entité souhaitée. Remarque : la classe Repository n'a pas besoin d'exister
        // find() attend l'ID permettant de charger l'entité
        $vehicle = $em->getRepository('App:Vehicle')->find($id); // Ou $em->getRepository('App\Entity\Vehicle')

        if(!$vehicle) {
            throw $this->createNotFoundException("Véhicule non trouvé");
        }

        return new Response("<body>{$vehicle->getId()} {$vehicle->getPlate()}</body>");
    }

}
