<?php

namespace App\Repository;

use App\Entity\Demandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Demandes>
 */
class DemandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Demandes::class);
    }

    /**
     * Retourne les séminaires archivés (statut = 'Archivé')
     *
     * @return Demandes[]
     */
    public function findArchivedSeminars(): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.statut = :status')
            ->setParameter('status', 'Archivé') // ou 'archived', selon ta logique
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countArchivedSeminars(): int
{
    return $this->createQueryBuilder('d')
        ->select('COUNT(d.id)')
        ->andWhere('d.statut = :status')
        ->setParameter('status', 'Archivé') // adapte selon ton système de statut
        ->getQuery()
        ->getSingleScalarResult();
}
// src/Repository/DemandesRepository.php

// ... après les méthodes existantes

public function countByUser(int $userId): int
{
    return $this->createQueryBuilder('d')
        ->select('COUNT(d.id)')
        ->where('d.user = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getSingleScalarResult();
}

public function findRequestsForPresenter(int $userId, int $limit, int $offset): array
{
    return $this->createQueryBuilder('d')
        ->where('d.user = :userId')
        ->setParameter('userId', $userId)
        ->orderBy('d.createdAt', 'DESC')
        ->setMaxResults($limit)
        ->setFirstResult($offset)
        ->getQuery()
        ->getResult();
}
public function findLatestWithUser(int $limit): array
{
    return $this->createQueryBuilder('d')
        ->join('d.user', 'u')
        ->addSelect('u')
        ->orderBy('d.createdAt', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}
public function findLatestRequests(int $limit = 5): array
{
    return $this->createQueryBuilder('d')
        ->orderBy('d.createdAt', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}



}
