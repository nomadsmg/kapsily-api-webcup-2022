<?php

namespace App\DataTransformer\Capsule\UserPlan;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\Capsule\UserPlan\UserPlanSubscribeInput;
use App\Entity\Capsule\Balance\BalanceTransaction;
use App\Entity\Capsule\PlanPayment\PlanPayment;
use App\Entity\Capsule\UserPlan\UserPlan;
use App\Repository\Capsule\Balance\UserBalanceRepository;
use App\Repository\Capsule\Config\PricingPlan\PricingPlanRepository;
use App\Repository\Entity\Security\UserRepository;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class UserPlanSubscribeInputTransformer implements DataTransformerInterface
{
    public function __construct(private UserRepository $userRepository, private PricingPlanRepository $pricingPlanRepository)
    {
    }

    /**
     * @param UserPlanSubscribeInput $object
     * @param string $to
     * @param array $context
     * @return UserPlan|void
     */
    public function transform($object, string $to, array $context = []): UserPlan
    {
        return (new UserPlan())
            ->setUser($this->userRepository->getUserByUuid($object->user))
            ->setPricingPlan($this->pricingPlanRepository->getByIdentifier($object->planIdentifier));
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof UserPlan) {
            return false;
        }

        return UserPlan::class === $to
            && null !== ($context['input']['class'] ?? null)
            && ($context['collection_operation_name'] ?? null) === 'subscribe_to_plan';
    }
}
