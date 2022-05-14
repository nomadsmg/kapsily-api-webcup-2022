<?php

namespace App\Repository\Capsule\Config\PricingPlan;

use App\Entity\Capsule\Config\PricingPlan\PricingPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
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

    public function getDefaultFreePricingPlan(): PricingPlan
    {
        $defaultPricingPlan = $this->findOneBy([
            'level' => 0,
            'minds' => 0,
        ]);

        if (null === $defaultPricingPlan) {
            throw new EntityNotFoundException("Free pricing plan not found");
        }

        return $defaultPricingPlan;
    }

    public function getByIdentifier(string $identifier): PricingPlan
    {
        $pricingPlan = $this->findOneByIdentifier($identifier);

        if (null === $pricingPlan) {
            throw new EntityNotFoundException(sprintf('Pricing plan with identifier "%s" not found', $identifier));
        }

        return $pricingPlan;
    }
}
