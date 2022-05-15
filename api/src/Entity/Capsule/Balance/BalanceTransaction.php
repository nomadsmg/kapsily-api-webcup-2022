<?php

namespace App\Entity\Capsule\Balance;

use App\Entity\Capsule\PlanPayment\PlanPayment;
use App\Repository\Capsule\Balance\BalanceTransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: BalanceTransactionRepository::class)]
class BalanceTransaction
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\ManyToOne(targetEntity: UserBalance::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false, name: 'user_balance_uuid', referencedColumnName: 'uuid')]
    private UserBalance $balance;

    #[ORM\Column(type: 'string', length: 50)]
    private string $type;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $initializedAt;

    #[ORM\OneToOne(mappedBy: 'balanceTransaction', targetEntity: PlanPayment::class, cascade: ['persist', 'remove'])]
    private $planPayment;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->initializedAt = new \DateTime();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getBalance(): UserBalance
    {
        return $this->balance;
    }

    public function setBalance(UserBalance $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getInitializedAt(): ?\DateTimeInterface
    {
        return $this->initializedAt;
    }

    public function getPlanPayment(): ?PlanPayment
    {
        return $this->planPayment;
    }

    public function setPlanPayment(PlanPayment $planPayment): self
    {
        // set the owning side of the relation if necessary
        if ($planPayment->getBalanceTransaction() !== $this) {
            $planPayment->setBalanceTransaction($this);
        }

        $this->planPayment = $planPayment;

        return $this;
    }
}
