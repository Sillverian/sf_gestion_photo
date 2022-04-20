<?php

namespace App\Entity;

use App\Repository\FolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FolderRepository::class)]
class Folder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $folderName;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parentFolder')]
    private $folder;

    #[ORM\OneToMany(mappedBy: 'folder', targetEntity: self::class)]
    private $parentFolder;

    #[ORM\OneToMany(mappedBy: 'folder', targetEntity: Photo::class)]
    private $photos;

    public function __construct()
    {
        $this->parentFolder = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFolderName(): ?string
    {
        return $this->folderName;
    }

    public function setFolderName(string $folderName): self
    {
        $this->folderName = $folderName;

        return $this;
    }

    public function getFolder(): ?self
    {
        return $this->folder;
    }

    public function setFolder(?self $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParentFolder(): Collection
    {
        return $this->parentFolder;
    }

    public function addParentFolder(self $parentFolder): self
    {
        if (!$this->parentFolder->contains($parentFolder)) {
            $this->parentFolder[] = $parentFolder;
            $parentFolder->setFolder($this);
        }

        return $this;
    }

    public function removeParentFolder(self $parentFolder): self
    {
        if ($this->parentFolder->removeElement($parentFolder)) {
            // set the owning side to null (unless already changed)
            if ($parentFolder->getFolder() === $this) {
                $parentFolder->setFolder(null);
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
            $photo->setFolder($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getFolder() === $this) {
                $photo->setFolder(null);
            }
        }

        return $this;
    }
}
