<?php

namespace App\Entity;

use App\Repository\MetaValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetaValueRepository::class)]
class MetaValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 60)]
    private $value;

    #[ORM\ManyToOne(targetEntity: MetaData::class, inversedBy: 'metaValues')]
    #[ORM\JoinColumn(nullable: false)]
    private $metadata;

    #[ORM\ManyToMany(targetEntity: Photo::class, mappedBy: 'metadata')]
    private $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getMetadata(): ?MetaData
    {
        return $this->metadata;
    }

    public function setMetadata(?MetaData $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->addMetadata($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            $photo->removeMetadata($this);
        }

        return $this;
    }
}
