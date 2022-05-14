<?php

namespace App\Entity\Capsule\PlanPayment;

use App\Entity\Capsule\UserPlan\UserPlan;
use App\Repository\Capsule\PlanPayment\PlanPaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PlanPaymentRepository::class)]
class PlanPayment implements PlanPaymentInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $initializedAt;

    #[ORM\Column(type: 'string', length: 50)]
    private string $status;

    #[ORM\ManyToOne(targetEntity: UserPlan::class, inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false, name: 'user_plan_uuid', referencedColumnName: 'uuid')]
    private UserPlan $userPlan;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->initializedAt = new \DateTime();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getInitializedAt(): \DateTimeInterface
    {
        return $this->initializedAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isDone(): bool
    {
        return self::PAYMENT_STATUS_DONE === $this->status;
    }

    public function isCanceled(): bool
    {
        return self::PAYMENT_STATUS_CANCELED === $this->status;
    }

    public function getUserPlan(): UserPlan
    {
        return $this->userPlan;
    }

    public function setUserPlan(UserPlan $userPlan): self
    {
        $this->userPlan = $userPlan;

        return $this;
    }
}
