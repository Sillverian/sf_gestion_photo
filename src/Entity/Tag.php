<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $tagName;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parentTag')]
    private $tag;

    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: self::class)]
    private $parentTag;

    #[ORM\ManyToMany(targetEntity: Photo::class, mappedBy: 'tag')]
    private $photos;

    public function __construct()
    {
        $this->parentTag = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagName(): ?string
    {
        return $this->tagName;
    }

    public function setTagName(string $tagName): self
    {
        $this->tagName = $tagName;

        return $this;
    }

    public function getTag(): ?self
    {
        return $this->tag;
    }

    public function setTag(?self $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParentTag(): Collection
    {
        return $this->parentTag;
    }

    public function addParentTag(self $parentTag): self
    {
        if (!$this->parentTag->contains($parentTag)) {
            $this->parentTag[] = $parentTag;
            $parentTag->setTag($this);
        }

        return $this;
    }

    public function removeParentTag(self $parentTag): self
    {
        if ($this->parentTag->removeElement($parentTag)) {
            // set the owning side to null (unless already changed)
            if ($parentTag->getTag() === $this) {
                $parentTag->setTag(null);
            }
        }

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
            $photo->addTag($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            $photo->removeTag($this);
        }

        return $this;
    }
}
