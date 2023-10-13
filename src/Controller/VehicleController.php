<?php

namespace App\Controller;

use App\Entity\Vehicle;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
            ->setManufactureDate(new DateTime('2017-11-24'))->setDescription('Très belle voiture');

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
            ->setManufactureDate(new DateTime('2017-11-24'))->setDescription('Très belle voiture');
        $vehicle2 = clone($vehicle);
        $entityManager->persist($vehicle);

        if ($entityManager->contains($vehicle)) { /* true */
            dump('$vehicle1 est connu');
        }
        if ($entityManager->contains($vehicle2)) { /* false */
            dump('$vehicle2 est connu');
        }
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

    #[Route('/show/{id}', name: 'vehicle_show')]
    public function showAction($id, EntityManagerInterface $em): Response
    {
        // Préciser l'entité souhaitée. Remarque : la classe Repository n'a pas besoin d'exister
        // find() attend l'ID permettant de charger l'entité
        $vehicle = $em->getRepository(Vehicle::class)->find($id);

        if (!$vehicle) {
            throw $this->createNotFoundException("Véhicule non trouvé");
        }

        return new Response("<body>{$vehicle->getId()} {$vehicle->getPlate()}</body>");
    }

    #[Route('/test-repository', name: 'vehicle_test_repository')]
    public function testRepositoryAction(EntityManagerInterface $em): Response
    {
        // Charger un seul objet
        $vehicle1 = $em->getRepository(Vehicle::class)->find(1);
        $vehicle2 = $em->find(Vehicle::class, 1);

        // Charger un seul objet correspondant aux critères donnés. Si plusieurs résultats, le premier est pris
        $vehicle3 = $em->getRepository(Vehicle::class)->findOneBy(['plate' => 'AB-123-CD', 'mileage' => 58000]);

        // Charger tous les objets
        $vehicles1 = $em->getRepository(Vehicle::class)->findAll();

        // Charger tous les objets correspondant aux critères donnés
        $vehicles2 = $em->getRepository(Vehicle::class)->findBy(['plate' => 'AB-123-CD', 'mileage' => 58000]);

        // Utilisation plus complète de findBy
        $vehicles3 = $em->getRepository(Vehicle::class)->findBy(
            ['plate' => 'AB-123-CD', 'mileage' => 58000], // Les critères de sélection
            ['manufactureDate' => 'desc'], // Les critères de tri
            5, // Le nombre de résultats
            0 // Offset => 0 : commencer au premier résultat
        );

        dump($vehicle1, $vehicle2, $vehicle3, $vehicles1, $vehicles2, $vehicles3);
        return new Response('<body></body>');
    }


    #[Route('/test-repository-magic', name: 'vehicle_test_repository_magic')]
    public function testRepositoryMagicAction(EntityManagerInterface $em): Response
    {
        // findByX($value) : méthode magique pour charger des entités à partir d'un de ses attributs
        // Fonctionne si x est un attribut de l'entité
        // Retourne comme findBy() un tableau d'entités
        $vehicles = $em->getRepository(Vehicle::class)->findByPlate('AB-123-CD');

        // findOneByX($value) : idem findByX() mais ne retourne que la première entité
        // Fonctionne si x est un attribut de l'entité
        // Retourne null si pas de résultat trouvé, une entité sinon
        $vehicle = $em->getRepository(Vehicle::class)->findOneByPlate('AB-123-CD');

        dump($vehicles, $vehicle);
        return new Response('<body></body>');
    }

    #[Route('/my-find-all', name: 'vehicle_my_find_all')]
    public function testMyFindAllAction(EntityManagerInterface $em): Response
    {
        $vehicles = $em->getRepository(Vehicle::class)->myFindAll();
        $vehicles2 = $em->getRepository(Vehicle::class)->myFindAllBis();
        dump($vehicles, $vehicles2);
        return new Response('<body></body>');
    }

    #[Route('/test-repository-where', name: 'vehicle_test_repository_where')]
    public function testWhereAction(EntityManagerInterface $em): Response
    {
        $vehicle = $em->getRepository(Vehicle::class)->myFind(1);
        $vehicles = $em->getRepository(Vehicle::class)
            ->findByMileageAndYear(50000, 100000, 2017);
        dump($vehicle, $vehicles);
        return new Response('<body></body>');
    }

    #[Route('/test-repository-where-bis', name: 'vehicle_test_repository_where_bis')]
    public function testWhereBisAction(EntityManagerInterface $em): Response
    {
        $vehicles = $em->getRepository(Vehicle::class)
            ->findByMileageAndYearBis(50000, 100000, 2017);
        $vehicles2 = $em->getRepository(Vehicle::class)
            ->findByPriceAndYear(15000, 20000, 2017);
        dump($vehicles, $vehicles2);
        return new Response('<body></body>');
    }

    #[Route('/test-repository-dql', name: 'vehicle_test_repository_dql')]
    public function testRepositoryDqlAction(EntityManagerInterface $em): Response
    {
        $vehicles = $em->getRepository(Vehicle::class)->myFindAllDql();
        $vehicle = $em->getRepository(Vehicle::class)->myFindDql(1);
        dump($vehicles, $vehicle);
        return new Response('<body></body>');
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/test-query-results', name: 'vehicle_test_query_results')]
    public function testQueryResults(EntityManagerInterface $em): Response
    {
        // Attention, le code ci-dessous est normalement écrit dans le Repository, on se concentre ici uniquement sur
        // la manière de récupérer les résultats en analysant les différences.

        dump("Exemples d'utilisation de getResult()");
        dump($em->createQuery("SELECT v FROM App:Vehicle v")->getResult());
        dump($em->createQuery("SELECT v FROM App:Vehicle v WHERE v.id = 1")->getResult());
        dump("----------------------");

        dump("Exemples d'utilisation de getArrayResult()");
        dump($em->createQuery("SELECT v FROM App:Vehicle v")->getArrayResult());
        dump($em->createQuery("SELECT v FROM App:Vehicle v WHERE v.id = 1")->getArrayResult());
        dump("----------------------");

        dump("Différences entre getArrayResult() et getScalarResult()");
        $query = $em->createQuery("SELECT v FROM App:Vehicle v WHERE v.id = 1");
        dump($query->getArrayResult());
        dump($query->getScalarResult());
        dump("----------------------");

        $query = $em->createQuery("SELECT v, v.manufactureDate FROM App:Vehicle v WHERE v.id = 1");
        dump($query->getArrayResult());
        dump($query->getScalarResult());
        dump("----------------------");

        dump("Exemples d'utilisation de getOneOrNullResult() et getSingleResult()");
        dump($em->createQuery("SELECT v FROM App:Vehicle v WHERE v.id = 1")->getOneOrNullResult());
        dump($em->createQuery("SELECT v FROM App:Vehicle v WHERE v.id = 1")->getSingleResult());
        dump("----------------------");

        dump("Exemple d'utilisation de getSingleScalarResult()");
        dump($em->createQuery("SELECT count(v) FROM App:Vehicle v")->getSingleScalarResult());
        dump("----------------------");

        return new Response('<body></body>');
    }

    #[Route(
        '/my-find-all-with-paging/{currentPage}/{nbPerPage}',
        name: 'vehicle_my_find_all_with_paging',
        requirements: ['currentPage' => '\d+', 'nbPerPage' => '\d+']
    )]
    public function testMyFindAllWithPagingAction(EntityManagerInterface $em, $currentPage, $nbPerPage): Response
    {
        $vehicles = $em->getRepository(Vehicle::class)
            ->myFindAllWithPaging($currentPage, $nbPerPage);

        // Nombre total de résultats hors pagination
        dump(count($vehicles));

        // Nombre total de pages construit à partir du nombre total de résultats
        $nbTotalPages = intval(ceil(count($vehicles) / $nbPerPage));
        dump($nbTotalPages);

        // Il est possible d'itérer sur l'objet Paginator comme s'il s'agissait d'un résultat classique
        foreach ($vehicles as $vehicle) {
            dump($vehicle);
        }
        return new Response('<body></body>');
    }

}
