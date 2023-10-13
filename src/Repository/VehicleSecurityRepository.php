<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\VehicleSecurity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleSecurity>
 *
 * @method VehicleSecurity|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleSecurity|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleSecurity[]    findAll()
 * @method VehicleSecurity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleSecurityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleSecurity::class);
    }

    public function save(VehicleSecurity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VehicleSecurity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VehicleSecurity[] Returns an array of VehicleSecurity objects
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

//    public function findOneBySomeField($value): ?VehicleSecurity
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
