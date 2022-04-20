<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 70)]
    private $fileName;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $legend;

    #[ORM\ManyToOne(targetEntity: Folder::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private $folder;

    #[ORM\OneToMany(mappedBy: 'photo', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'photo', targetEntity: Notation::class, orphanRemoval: true)]
    private $notations;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'photos')]
    private $tag;

    #[ORM\ManyToMany(targetEntity: ColorCode::class, inversedBy: 'photos')]
    private $colorCode;

    #[ORM\ManyToMany(targetEntity: MetaValue::class, inversedBy: 'photos')]
    private $metadata;

    #[ORM\OneToMany(mappedBy: 'photo', targetEntity: Validation::class, orphanRemoval: true)]
    private $validations;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->notation = new ArrayCollection();
        $this->notations = new ArrayCollection();
        $this->tag = new ArrayCollection();
        $this->colorCode = new ArrayCollection();
        $this->metadata = new ArrayCollection();
        $this->validations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getLegend(): ?string
    {
        return $this->legend;
    }

    public function setLegend(?string $legend): self
    {
        $this->legend = $legend;

        return $this;
    }

    public function getFolder(): ?Folder
    {
        return $this->folder;
    }

    public function setFolder(?Folder $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPhoto($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPhoto() === $this) {
                $comment->setPhoto(null);
            }
        }

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

    /**
     * @return Collection<int, Notation>
     */
    public function getNotations(): Collection
    {
        return $this->notations;
    }

    public function addNotation(Notation $notation): self
    {
        if (!$this->notations->contains($notation)) {
            $this->notations[] = $notation;
            $notation->setPhoto($this);
        }

        return $this;
    }

    public function removeNotation(Notation $notation): self
    {
        if ($this->notations->removeElement($notation)) {
            // set the owning side to null (unless already changed)
            if ($notation->getPhoto() === $this) {
                $notation->setPhoto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, ColorCode>
     */
    public function getColorCode(): Collection
    {
        return $this->colorCode;
    }

    public function addColorCode(ColorCode $colorCode): self
    {
        if (!$this->colorCode->contains($colorCode)) {
            $this->colorCode[] = $colorCode;
        }

        return $this;
    }

    public function removeColorCode(ColorCode $colorCode): self
    {
        $this->colorCode->removeElement($colorCode);

        return $this;
    }

    /**
     * @return Collection<int, MetaValue>
     */
    public function getMetadata(): Collection
    {
        return $this->metadata;
    }

    public function addMetadata(MetaValue $metadata): self
    {
        if (!$this->metadata->contains($metadata)) {
            $this->metadata[] = $metadata;
        }

        return $this;
    }

    public function removeMetadata(MetaValue $metadata): self
    {
        $this->metadata->removeElement($metadata);

        return $this;
    }

    /**
     * @return Collection<int, Validation>
     */
    public function getValidations(): Collection
    {
        return $this->validations;
    }

    public function addValidation(Validation $validation): self
    {
        if (!$this->validations->contains($validation)) {
            $this->validations[] = $validation;
            $validation->setPhoto($this);
        }

        return $this;
    }

    public function removeValidation(Validation $validation): self
    {
        if ($this->validations->removeElement($validation)) {
            // set the owning side to null (unless already changed)
            if ($validation->getPhoto() === $this) {
                $validation->setPhoto(null);
            }
        }

        return $this;
    }
}
