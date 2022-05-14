<?php

namespace App\Repository\Capsule\Config\PricingPlan;

use App\Entity\Capsule\Config\PricingPlan\PricingPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PricingPlan>
 *
 * @method PricingPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method PricingPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method PricingPlan[]    findAll()
 * @method PricingPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricingPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PricingPlan::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PricingPlan $entity, bool $flush = false): void
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
    public function remove(PricingPlan $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

//    /**
//     * @return PricingPlan[] Returns an array of PricingPlan objects
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

//    public function findOneBySomeField($value): ?PricingPlan
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
