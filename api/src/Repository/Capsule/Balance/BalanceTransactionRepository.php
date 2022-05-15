<?php

namespace App\Repository\Capsule\Balance;

use App\Entity\Capsule\Balance\BalanceTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BalanceTransaction>
 *
 * @method BalanceTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method BalanceTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method BalanceTransaction[]    findAll()
 * @method BalanceTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BalanceTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BalanceTransaction::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BalanceTransaction $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(BalanceTransaction $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

//    /**
//     * @return BalanceTransaction[] Returns an array of BalanceTransaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BalanceTransaction
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
