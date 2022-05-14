<?php

namespace App\DataTransformer\Capsule\UserPlan;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\Capsule\UserPlan\UserPlanSubscribeInput;
use App\Entity\Capsule\UserPlan\UserPlan;
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
     * @return object|void
     */
    public function transform($object, string $to, array $context = [])
    {
        /** @var UserPlan */
        $userPan = $context[AbstractNormalizer::OBJECT_TO_POPULATE];

        return $userPan
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
            && ($context['item_operation_name'] ?? null) === 'subscribe_to_plan';
    }
}
