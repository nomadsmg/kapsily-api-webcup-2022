<?php

namespace App\Entity\Capsule\Config\PricingPlan;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\Capsule\Config\PricingPlan\PricingPlanOfferRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PricingPlanOfferRepository::class)]
#[ApiResource()]
class PricingPlanOffer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\ManyToOne(targetEntity: Offer::class, inversedBy: 'pricingPlanOffers')]
    #[ORM\JoinColumn(nullable: false, name: 'offer_uuid', referencedColumnName: 'uuid')]
    private Offer $offer;

    #[ORM\ManyToOne(targetEntity: PricingPlan::class, inversedBy: 'pricingPlanOffers')]
    #[ORM\JoinColumn(nullable: false, name: 'pricing_plan_uuid', referencedColumnName: 'uuid')]
    private PricingPlan $pricingPlan;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getOffer(): Offer
    {
        return $this->offer;
    }

    public function setOffer(Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
    }

    public function getPricingPlan(): PricingPlan
    {
        return $this->pricingPlan;
    }

    public function setPricingPlan(PricingPlan $pricingPlan): self
    {
        $this->pricingPlan = $pricingPlan;

        return $this;
    }
}
