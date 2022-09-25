<?php

namespace App\Entity\Capsule\Balance;

use App\Entity\Security\User;
use App\Repository\Capsule\Balance\UserBalanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserBalanceRepository::class)]
class UserBalance
{
    const DEFAULT_FUND = 100;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\OneToOne(inversedBy: 'balance', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, name: 'user_uuid', referencedColumnName: 'uuid')]
    private User $user;

    #[ORM\Column(type: 'float')]
    private float $current;

    #[ORM\OneToMany(mappedBy: 'balance', targetEntity: BalanceTransaction::class)]
    private $transactions;

    public function __construct(float $fund = self::DEFAULT_FUND)
    {
        $this->uuid = Uuid::v6();
        $this->current = $fund;
        $this->transactions = new ArrayCollection();
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

    public function getCurrent(): float
    {
        return $this->current;
    }

    public function setCurrent(float $current): self
    {
        $this->current = $current;

        return $this;
    }

    /**
     * @return Collection<int, BalanceTransaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(BalanceTransaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setBalance($this);
        }

        return $this;
    }

    public function removeTransaction(BalanceTransaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getBalance() === $this) {
                $transaction->setBalance(null);
            }
        }

        return $this;
    }
}
