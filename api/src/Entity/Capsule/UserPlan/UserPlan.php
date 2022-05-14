<?php

namespace App\Entity\Capsule\UserPlan;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\Capsule\UserPlan\UserPlanSubscribeInput;
use App\Entity\Capsule\Config\PricingPlan\PricingPlan;
use App\Entity\Capsule\PlanPayment\PlanPayment;
use App\Entity\Security\User;
use App\Repository\Capsule\UserPlan\UserPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserPlanRepository::class)]
#[ApiResource(
    collectionOperations: [
        'subscribe_to_plan' => [
            'method' => Request::METHOD_POST,
            'input' => UserPlanSubscribeInput::class,
        ]
    ]
)]
class UserPlan
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'pricingPlans')]
    #[ORM\JoinColumn(nullable: false, name: 'user_uuid', referencedColumnName: 'uuid')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: PricingPlan::class, inversedBy: 'userMembers')]
    #[ORM\JoinColumn(nullable: false, name: 'pricing_plan_uuid', referencedColumnName: 'uuid')]
    private PricingPlan $pricingPlan;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $attachmentDate;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $canceledAt = null;

    #[ORM\OneToMany(mappedBy: 'userPlan', targetEntity: PlanPayment::class)]
    private $payments;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->attachmentDate = new \DateTime();
        $this->payments = new ArrayCollection();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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

    public function getAttachmentDate(): \DateTimeInterface
    {
        return $this->attachmentDate;
    }

    public function isPlanCanceled(): bool
    {
        return null !== $this->canceledAt;
    }

    public function cancelPlan(): self
    {
        $this->canceledAt = new \DateTime();

        return $this;
    }

    /**
     * @return Collection<int, PlanPayment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(PlanPayment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setUserPlan($this);
        }

        return $this;
    }

    public function removePayment(PlanPayment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getUserPlan() === $this) {
                $payment->setUserPlan(null);
            }
        }

        return $this;
    }
}
