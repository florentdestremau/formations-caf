<?php

namespace App\Repository;

use App\Entity\TrainingReimbursement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrainingReimbursement>
 *
 * @method TrainingReimbursement|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingReimbursement|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingReimbursement[]    findAll()
 * @method TrainingReimbursement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingReimbursementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingReimbursement::class);
    }

    //    /**
    //     * @return TrainingReimbursement[] Returns an array of TrainingReimbursement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TrainingReimbursement
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
