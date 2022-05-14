<?php

namespace App\Entity\Capsule\Config\PricingPlan;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\Capsule\Config\PricingPlan\PricingPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PricingPlanRepository::class)]
#[ApiResource()]
class PricingPlan
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\Column(type: 'string', length: 25)]
    private string $identifier;

    #[ORM\Column(type: 'string', length: 100)]
    private string $label;

    #[ORM\Column(type: 'integer')]
    private int $level;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'integer')]
    private int $minds;

    #[ORM\Column(type: 'integer')]
    private int $years;

    #[ORM\OneToMany(mappedBy: 'pricingPlan', targetEntity: PricingPlanOffer::class)]
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMinds(): int
    {
        return $this->minds;
    }

    public function setMinds(int $minds): self
    {
        $this->minds = $minds;

        return $this;
    }

    public function getYears(): int
    {
        return $this->years;
    }

    public function setYears(int $years): self
    {
        $this->years = $years;

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
            $pricingPlanOffer->setPricingPlan($this);
        }

        return $this;
    }

    public function removePricingPlanOffer(PricingPlanOffer $pricingPlanOffer): self
    {
        if ($this->pricingPlanOffers->removeElement($pricingPlanOffer)) {
            // set the owning side to null (unless already changed)
            if ($pricingPlanOffer->getPricingPlan() === $this) {
                $pricingPlanOffer->setPricingPlan(null);
            }
        }

        return $this;
    }
}
