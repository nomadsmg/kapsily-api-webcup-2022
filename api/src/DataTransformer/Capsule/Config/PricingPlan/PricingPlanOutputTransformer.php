<?php

namespace App\DataTransformer\Capsule\Config\PricingPlan;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\Capsule\Config\PricingPlan\PricingPlanOutput;
use App\Entity\Capsule\Config\PricingPlan\PricingPlan;

class PricingPlanOutputTransformer implements DataTransformerInterface
{
    /**
     * @param PricingPlan $object
     * @param string $to
     * @param array $context
     * @return PricingPlanOutput|void
     */
    public function transform($object, string $to, array $context = []): PricingPlanOutput
    {
        return (new PricingPlanOutput())
            ->setUuid($object->getUuid())
            ->setIdentifier($object->getIdentifier())
            ->setLabel($object->getLabel())
            ->setLevel($object->getLevel())
            ->setDescription($object->getDescription())
            ->setMinds($object->getMinds())
            ->setYears($object->getYears());
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return PricingPlanOutput::class === $to && $data instanceof PricingPlan;
    }
}
