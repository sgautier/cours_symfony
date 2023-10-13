<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\VehicleToVehicleRepair;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleToVehicleRepair>
 *
 * @method VehicleToVehicleRepair|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleToVehicleRepair|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleToVehicleRepair[]    findAll()
 * @method VehicleToVehicleRepair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleToVehicleRepairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleToVehicleRepair::class);
    }

    public function save(VehicleToVehicleRepair $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VehicleToVehicleRepair $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VehicleToVehicleRepair[] Returns an array of VehicleToVehicleRepair objects
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

//    public function findOneBySomeField($value): ?VehicleToVehicleRepair
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
