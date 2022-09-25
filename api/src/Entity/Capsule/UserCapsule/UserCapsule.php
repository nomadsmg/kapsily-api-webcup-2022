<?php

namespace App\Entity\Capsule\UserCapsule;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Action\UserCapsule\HandleAddCapsuleAction;
use App\Entity\Media\Media;
use App\Entity\Security\User;
use App\Repository\Capsule\UserCapsule\UserCapsuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserCapsuleRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post'
    ],
    normalizationContext: [
        'groups' => ['default']
    ]
)]
class UserCapsule
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    #[Groups(['default'])]
    private Uuid $uuid;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    // TODO: define type
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'capsules', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false, name: 'user_uuid', referencedColumnName: 'uuid')]
    private User $user;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $lifetime;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private string $location;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $note = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $autoDestroyAfter = 0;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\OneToMany(mappedBy: 'userCapsule', targetEntity: Media::class, cascade: ['persist'])]
    private $medias;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->createdAt = new \DateTime();
        $this->medias = new ArrayCollection();
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

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
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

    /**
     * @return Collection<int, Media>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setUserCapsule($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getUserCapsule() === $this) {
                $media->setUserCapsule(null);
            }
        }

        return $this;
    }
}
