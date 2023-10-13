<?php

namespace App\Repository;

use App\Entity\Vehicle;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Vehicle>
 *
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function oneMethodInMyRepository(): void
    {
        // Solution 1 :
        $queryBuilder = $this->_em->createQueryBuilder() // Créer un query builder vide
            ->select('v') // Préciser quelles colonnes sélectionner (toute ici)
            ->from($this->_entityName, 'v'); // Préciser sur quelle entité

        dump($queryBuilder);

        // Solution 2 équivalente à privilégier !
        $queryBuilder = $this->createQueryBuilder('v');

        dump($queryBuilder);

        // ... suite de notre méthode
    }

    public function myFindAll(): mixed
    {
        // Récupération du QueryBuilder ==> select * from vehicle
        $queryBuilder = $this->createQueryBuilder('v');

        // Pas besoin d'autres critères car on veut tout récupérer

        // Récupération de la Query à partir du QueryBuilder
        $query = $queryBuilder->getQuery();

        // Récupération des résultats à partir de la Query
        $results = $query->getResult();

        return $results;
    }

    // La même chose sans commentaires ni variables inutiles
    public function myFindAllBis(): mixed
    {
        return $this->createQueryBuilder('v')
            ->getQuery()
            ->getResult();
    }

    public function myFind($id): mixed
    {
        $qb = $this->createQueryBuilder('v')
            // Ajout d'une contrainte sur la propriété id de l'entité v
            ->where('v.id = :my_id')
            // Attribution de la valeur au paramètre (id reçu en paramètre)
            ->setParameter('my_id', $id);
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws Exception
     */
    public function findByMileageAndYear($mileageMin, $mileageMax, $year): mixed
    {
        $qb = $this->createQueryBuilder('v')
            ->where('v.mileage >= :mileage_min')
            ->setParameter('mileage_min', $mileageMin)
            ->andWhere('v.mileage <= :mileage_max')
            ->setParameter('mileage_max', $mileageMax)
            ->andWhere('v.manufactureDate BETWEEN :begin AND :end')
            ->setParameter('begin', new DateTime($year . '-01-01'))
            ->setParameter('end', new DateTime($year . '-12-31'));
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws Exception
     */
    public function findByMileageAndYearBis($mileageMin, $mileageMax, $year): mixed
    {
        $qb = $this->createQueryBuilder('v')
            ->where('v.mileage >= :mileage_min')
            ->setParameter('mileage_min', $mileageMin)
            ->andWhere('v.mileage <= :mileage_max')
            ->setParameter('mileage_max', $mileageMax);
        $this->whereYear($qb, $year);
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws Exception
     */
    public function findByPriceAndYear($priceMin, $priceMax, $year): mixed
    {
        $qb = $this->createQueryBuilder('v')
            ->where('v.price >= :price_min')
            ->setParameter('price_min', $priceMin)
            ->andWhere('v.price <= :price_max')
            ->setParameter('price_max', $priceMax);
        $this->whereYear($qb, $year);
        return $qb->getQuery()->getResult();
    }

    /**
     * @throws Exception
     */
    public function whereYear(QueryBuilder $qb, $year): void
    {
        $qb
            ->andWhere('v.manufactureDate BETWEEN :begin AND :end')
            ->setParameter('begin', new DateTime($year . '-01-01'))
            ->setParameter('end', new DateTime($year . '-12-31'));
    }

    public function myFindAllDql(): mixed
    {
        return $this->_em->createQuery("SELECT v FROM App:Vehicle v")->getResult();
    }

    public function myFindDql($id): mixed
    {
        $query = $this->_em->createQuery("SELECT v FROM App:Vehicle v WHERE v.id = :id");
        $query->setParameter('id', $id);
        return $query->getResult();
    }

    public function myFindAllWithPaging($currentPage, $nbPerPage): Paginator
    {
        $query = $this->createQueryBuilder('v')
            ->getQuery()
            ->setFirstResult(($currentPage - 1) * $nbPerPage) // Premier élément de la page
            ->setMaxResults($nbPerPage); // Nombre d'éléments par page

        // Equivalent de getResult() mais un count() sur cet objet retourne le nombre de résultats hors pagination
        return new Paginator($query);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByPlateWithSecurity(string $plate): mixed
    {
        return
            // SELECT v.* FROM vehicle v
            $this->createQueryBuilder('v')
                // WHERE v.plate = $plate
                ->where('v.plate=:plate')->setParameter('plate', $plate)

                // LEFT JOIN vehicle_security s ON v.vehicle_security_id = s.id
                ->leftJoin('v.vehicleSecurity', 's')
                // 1er paramètre de leftJoin() : propriété de l'entité principale (celle qui est définie dans le FROM,
                // en l'occurrence Vehicle) sur laquelle la jointure se fait => Vehicle a bien la propriété vehicleSecurity
                // 2ème argument de leftJoin() : alias de l'entité jointe utilisé dans la requête
                // On fait un LEFT JOIN car la relation est facultative. Sinon, on ferait un INNER JOIN

                // Ajoute s.* au SELECT
                // On utilise addSelect() car select() remplace tout ce qui est dans le SELECT
                ->addSelect('s')

                // Le résultat ou null si pas de résultat
                ->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByPlateWithSecurityAnd4Stars(string $plate): mixed
    {
        return $this->createQueryBuilder('v')
            ->where('v.plate=:plate')->setParameter('plate', $plate)
            ->leftJoin('v.vehicleSecurity', 's', 'WITH', 's.euroNcapStars >= 4')
            ->addSelect('s')
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByPlateWithModel(string $plate): mixed
    {
        return $this->createQueryBuilder('v')
            ->where('v.plate=:plate')->setParameter('plate', $plate)
            ->leftJoin('v.vehicleModel', 'm')
            ->addSelect('m')
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByPlateWithEquipments(string $plate): mixed
    {
        return $this->createQueryBuilder('v')
            ->where('v.plate=:plate')->setParameter('plate', $plate)
            // Noter que ce leftJoin() génère en fait
            // 2 jointures au niveau SQL
            ->leftJoin('v.equipments', 'e')
            ->addSelect('e')
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByPlateWithVehicleToVehicleRepair(string $plate)
    {
        return $this->createQueryBuilder('v')
            ->where('v.plate=:plate')->setParameter('plate', $plate)
            ->leftJoin('v.vehicleToVehicleRepairs', 'vvr')
            ->addSelect('vvr')
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByPlateWithVehicleToVehicleRepairAndVehicleRepair(string $plate)
    {
        return $this->createQueryBuilder('v')
            ->where('v.plate=:plate')->setParameter('plate', $plate)
            ->leftJoin('v.vehicleToVehicleRepairs', 'vvr')
            ->addSelect('vvr')
            // Seconde jointure en INNER car on est certain d'avoir une réparation dès lors qu'on a une association
            ->innerJoin('vvr.vehicleRepair', 'vr')
            ->addSelect('vr')
            ->getQuery()->getOneOrNullResult();
    }

    public function save(Vehicle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vehicle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Vehicle[] Returns an array of Vehicle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vehicle
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
