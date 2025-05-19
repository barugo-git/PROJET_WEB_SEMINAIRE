<?php

namespace App\Repository;

use App\Entity\Programmations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Programmations>
 */
class ProgrammationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programmations::class);
    }

    //    /**
    //     * @return Programmations[] Returns an array of Programmations objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Programmations
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    // src/Repository/ProgrammationsRepository.php

public function findUpcomingSeminars(int $limit): array
{
    return $this->createQueryBuilder('p')
        ->join('p.demande', 'd')
        ->join('d.user', 'u')
        ->addSelect('d', 'u')
        ->where('p.dateSeminaire >= :today')
        ->setParameter('today', new \DateTime())
        ->orderBy('p.dateSeminaire', 'ASC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

}
