<?php

namespace App\Entity\Capsule\UserCapsule;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Security\User;
use App\Repository\Capsule\UserCapsule\UserCapsuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserCapsuleRepository::class)]
#[ApiResource()]
class UserCapsule
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    #[ORM\Column(type: 'string', length: 50)]
    private string $type;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'capsules')]
    #[ORM\JoinColumn(nullable: false, name: 'user_uuid', referencedColumnName: 'uuid')]
    private User $user;

    #[ORM\Column(type: 'integer')]
    private int $lifetime;

    #[ORM\Column(type: 'array')]
    private array $location = [];

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $note = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $autoDestroyAfter = 0;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->createdAt = new \DateTime();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLifetime(): ?int
    {
        return $this->lifetime;
    }

    public function setLifetime(int $lifetime): self
    {
        $this->lifetime = $lifetime;

        return $this;
    }

    public function getLocation(): ?array
    {
        return $this->location;
    }

    public function setLocation(array $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getAutoDestroyAfter(): ?int
    {
        return $this->autoDestroyAfter;
    }

    public function setAutoDestroyAfter(?int $autoDestroyAfter): self
    {
        $this->autoDestroyAfter = $autoDestroyAfter;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
