<?php

namespace App\DataFixtures\Config\Pricing;

use App\Entity\Capsule\Config\PricingPlan\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OfferFixture extends Fixture implements PricingFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (self::OFFERS as $offerIndex => $offerData) {
            $offer = (new Offer())
                ->setIdentifier($offerData['identifier'])
                ->setName($offerData['name']);

            $manager->persist($offer);

            $this->addReference('offer_' . $offerData['identifier'], $offer);
        }

        $manager->flush();
    }
}
