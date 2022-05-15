<?php

namespace App\Entity\Media;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Action\Media\MediaAction;
use App\Entity\Capsule\UserCapsule\UserCapsule;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\Table(name: '`media`')]
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     itemOperations={"get","delete"},
 *     collectionOperations={
 *          "get",
 *          "post" = {
 *              "controller" = MediaAction::class,
 *              "deserialize" = false,
 *              "openapi_context" = {
 *                  "requestBody" = {
 *                      "description" = "File upload",
 *                      "required" = true,
 *                      "content" = {
 *                          "multipart/form-data" = {
 *                              "schema" = {
 *                                  "type" = "object",
 *                                  "properties" = {
 *                                      "file" = {
 *                                          "type" = "string",
 *                                          "format" = "binary",
 *                                          "description" = "File to be uploaded",
 *                                      },
 *                                      "path" = {
 *                                          "type" = "string",
 *                                          "default" ="upload",
 *                                          "description" = "Relative dir",
 *                                      },
 *                                      "filename" = {
 *                                          "type" = "string",
 *                                          "description" = "Filename to display",
 *                                          "required" = false
 *                                      },
 *                                  },
 *                              },
 *                          },
 *                      },
 *                  },
 *              },
 *          },
 *     },
 * )
 */
class Media
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private Uuid $uuid;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"read", "uploaded_media"})
     */
    public ?string $filePath = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"read", "uploaded_media"})
     */
    public ?string $url = null;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"uploaded_media"})
     */
    private ?string $filename = null;

    #[ORM\ManyToOne(targetEntity: UserCapsule::class, inversedBy: 'medias')]
    #[ORM\JoinColumn(nullable: true, name: 'user_capsule_uuid', referencedColumnName: 'uuid')]
    private $userCapsule;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @Groups({"read"})
     * @return string|null
     */
    public function getFilename(): ?string
    {
        if (null === $this->filename) {
            return basename($this->filePath);
        }

        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Media
     */
    public function setFilename(?string $filename): Media
    {
        $this->filename = $filename;
        return $this;
    }


    public function toArray()
    {
        return [
            'uuid' => $this->getUuid(),
            'filePath' => $this->filePath,
            'url' => $this->url,
            'filename' => $this->filename
        ];
    }

    public function getUserCapsule(): ?UserCapsule
    {
        return $this->userCapsule;
    }

    public function setUserCapsule(?UserCapsule $userCapsule): self
    {
        $this->userCapsule = $userCapsule;

        return $this;
    }
}
