<?php

namespace App\DataFixtures\Config\Pricing;

use App\Entity\Capsule\Config\PricingPlan\PricingPlan;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PricingPlanFixture extends Fixture implements PricingFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (self::PLANS as $planIndex => $planData) {
            $plan = (new PricingPlan())
                ->setLevel($planData['level'])
                ->setIdentifier($planData['identifier'])
                ->setLabel($planData['label'])
                ->setDescription($planData['description'])
                ->setMinds($planData['minds'])
                ->setYears($planData['years']);

            $manager->persist($plan);

            $this->addReference($planData['identifier'], $plan);
        }

        $manager->flush();
    }
}
