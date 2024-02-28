<?php

namespace App\Repository;

use App\Entity\RutaVisita;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RutaVisita>
 *
 * @method RutaVisita|null find($id, $lockMode = null, $lockVersion = null)
 * @method RutaVisita|null findOneBy(array $criteria, array $orderBy = null)
 * @method RutaVisita[]    findAll()
 * @method RutaVisita[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RutaVisitaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RutaVisita::class);
    }

//    /**
//     * @return RutaVisita[] Returns an array of RutaVisita objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    // public function aforo($idTour): ?int
    // {
    //     return $this->createQueryBuilder('ut')
    //         ->select('SUM(ut.columnaDeseada) AS total')
    //         ->andWhere('ut.tour = :idTour')
    //         ->setParameter('idTour', $idTour)
    //         ->getQuery()
    //         ->getSingleScalarResult();
    // }
}
