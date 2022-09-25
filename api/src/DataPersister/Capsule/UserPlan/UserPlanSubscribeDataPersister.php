<?php

namespace App\DataPersister\Capsule\UserPlan;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Capsule\Balance\BalanceTransaction;
use App\Entity\Capsule\PlanPayment\PlanPayment;
use App\Entity\Capsule\UserPlan\UserPlan;
use App\Repository\Capsule\Balance\UserBalanceRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserPlanSubscribeDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(private EntityManagerInterface $em, private UserBalanceRepository $userBalanceRepository)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @param UserPlan $data
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof UserPlan && ($context['collection_operation_name'] ?? null) === 'subscribe_to_plan';
    }

    /**
     * @param UserPlan $data
     */
    public function persist($data, array $context = [])
    {
        $userBalance = $this->userBalanceRepository->findOneBy([
            'user' => $data->getUser(),
        ]);

        if ($userBalance->getCurrent() < $data->getPricingPlan()->getMinds()) {
            throw new \Exception("Nonspendable fund balance");
        }

        $planPayment = (new PlanPayment())
            ->setUserPlan($data);

        $balanceTransaction = (new BalanceTransaction())
            ->setBalance($userBalance)
            ->setPlanPayment($planPayment)
            ->setType('pricing_plan');

        $userBalance->setCurrent($userBalance->getCurrent() - $data->getPricingPlan()->getMinds());

        $this->em->persist($planPayment);
        $this->em->persist($userBalance);
        $this->em->persist($balanceTransaction);

        $this->em->flush();

        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}
