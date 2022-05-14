<?php

namespace App\DataFixtures\Config\Pricing;

use App\Entity\Capsule\Config\PricingPlan\PricingPlanOffer;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PricingPlanOfferFixture extends Fixture implements PricingFixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (self::OFFER_PLANS as $planIdentifier => $offers) {
            $pricingPlan = $this->getReference($planIdentifier);

            foreach ($offers as $offerIndentifier) {
                $planOfferData = (new PricingPlanOffer())
                    ->setOffer($this->getReference($offerIndentifier))
                    ->setPricingPlan($pricingPlan);

                $manager->persist($planOfferData);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            OfferFixture::class,
            PricingPlanFixture::class,
        ];
    }
}
