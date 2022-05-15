<?php

namespace App\Entity\Security;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Capsule\Balance\UserBalance;
use App\Entity\Capsule\UserCapsule\UserCapsule;
use App\Entity\Capsule\UserPlan\UserPlan;
use App\Repository\Security\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource()]
class User implements SecurityInterface
{
    public const INDENTIFIER = 'email';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups([self::GP_PROFILE])]
    private Uuid $uuid;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups([self::GP_PROFILE])]
    private string $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([self::GP_PROFILE])]
    private ?string $firstname = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([self::GP_PROFILE])]
    private string $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $apiToken;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserPlan::class)]
    private $pricingPlans;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserBalance::class, cascade: ['persist', 'remove'])]
    private $balance;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserCapsule::class)]
    private $capsules;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->pricingPlans = new ArrayCollection();
        $this->balance = (new UserBalance())->setUser($this);
        $this->capsules = new ArrayCollection();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * @return Collection<int, UserPlan>
     */
    public function getPricingPlans(): Collection
    {
        return $this->pricingPlans;
    }

    public function addPricingPlan(UserPlan $pricingPlan): self
    {
        if (!$this->pricingPlans->contains($pricingPlan)) {
            $this->pricingPlans[] = $pricingPlan;
            $pricingPlan->setUser($this);
        }

        return $this;
    }

    public function removePricingPlan(UserPlan $pricingPlan): self
    {
        if ($this->pricingPlans->removeElement($pricingPlan)) {
            // set the owning side to null (unless already changed)
            if ($pricingPlan->getUser() === $this) {
                $pricingPlan->setUser(null);
            }
        }

        return $this;
    }

    public function getCurrentPlan(bool $returnIndefider = false): null|string|UserPlan
    {
        if ($this->pricingPlans->count() > 0) {
            /**
             * @var UserPlan
             */
            $currentPlan = $this->pricingPlans->last();

            return $returnIndefider ? $currentPlan->getPricingPlan()->getIdentifier() : $currentPlan;
        }

        return null;
    }

    public function getBalance(): ?UserBalance
    {
        return $this->balance;
    }

    public function setBalance(UserBalance $balance): self
    {
        // set the owning side of the relation if necessary
        if ($balance->getUser() !== $this) {
            $balance->setUser($this);
        }

        $this->balance = $balance;

        return $this;
    }

    #[Groups([self::GP_PROFILE])]
    public function getCurrentBalance(): float
    {
        return $this->balance->getCurrent();
    }

    /**
     * @return Collection<int, UserCapsule>
     */
    public function getCapsules(): Collection
    {
        return $this->capsules;
    }

    public function addCapsule(UserCapsule $capsule): self
    {
        if (!$this->capsules->contains($capsule)) {
            $this->capsules[] = $capsule;
            $capsule->setUser($this);
        }

        return $this;
    }

    public function removeCapsule(UserCapsule $capsule): self
    {
        if ($this->capsules->removeElement($capsule)) {
            // set the owning side to null (unless already changed)
            if ($capsule->getUser() === $this) {
                $capsule->setUser(null);
            }
        }

        return $this;
    }
}
