<?php

namespace App\Entity\Capsule\Config\PricingPlan;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\Capsule\Config\PricingPlan\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
#[ApiResource()]
class Offer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\Column(type: 'string', length: 25)]
    private string $identifier;

    #[ORM\Column(type: 'string', length: 150)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: PricingPlanOffer::class)]
    private $pricingPlanOffers;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->pricingPlanOffers = new ArrayCollection();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, PricingPlanOffer>
     */
    public function getPricingPlanOffers(): Collection
    {
        return $this->pricingPlanOffers;
    }

    public function addPricingPlanOffer(PricingPlanOffer $pricingPlanOffer): self
    {
        if (!$this->pricingPlanOffers->contains($pricingPlanOffer)) {
            $this->pricingPlanOffers[] = $pricingPlanOffer;
            $pricingPlanOffer->setOffer($this);
        }

        return $this;
    }

    public function removePricingPlanOffer(PricingPlanOffer $pricingPlanOffer): self
    {
        if ($this->pricingPlanOffers->removeElement($pricingPlanOffer)) {
            // set the owning side to null (unless already changed)
            if ($pricingPlanOffer->getOffer() === $this) {
                $pricingPlanOffer->setOffer(null);
            }
        }

        return $this;
    }
}
