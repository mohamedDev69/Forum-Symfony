<?php

namespace App\Repository;

use App\Entity\Inscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Inscription>
 *
 * @method Inscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscription[]    findAll()
 * @method Inscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscription::class);
    }

    /**
     * @return Inscription[] Returns an array of Inscription objects
     */
    public function findByEleveId($value): array
    {
        return $this->createQueryBuilder('i')
            ->select('i','atelier')
            ->innerJoin('i.atelier', 'atelier')
            ->andWhere('i.eleve = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySomeField($value): ?Inscription
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getNombreInscritsParAtelierEtCreneau($atelierId, $creneauId): string
    {
        $qb = $this->createQueryBuilder('i');

        $nbInscrit = $qb->select('COUNT(i.id)')
            ->join('i.atelier', 'a')
            ->where('a.id = :atelierId')
            ->andWhere('a.heure = :creneauId')
            ->setParameter('atelierId', $atelierId)
            ->setParameter('creneauId', $creneauId)
            ->getQuery()
            ->getSingleScalarResult();

        return $nbInscrit . " Inscrits";
    }
}
