<?php
namespace App\Controller;

use App\Entity\Vehicle;
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
    public function indexAction()
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

        return new Response('<body>Saved new vehicle with id '.$vehicle->getId().'</body>');
    }
}
