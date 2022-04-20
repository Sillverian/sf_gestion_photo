<?php

namespace App\Entity;

use App\Repository\MetaDataRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetaDataRepository::class)]
class MetaData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $label;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'metaData')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'metadata', targetEntity: MetaValue::class)]
    private $metaValues;

    public function __construct()
    {
        $this->metaValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
     * @return Collection<int, MetaValue>
     */
    public function getMetaValues(): Collection
    {
        return $this->metaValues;
    }

    public function addMetaValue(MetaValue $metaValue): self
    {
        if (!$this->metaValues->contains($metaValue)) {
            $this->metaValues[] = $metaValue;
            $metaValue->setMetadata($this);
        }

        return $this;
    }

    public function removeMetaValue(MetaValue $metaValue): self
    {
        if ($this->metaValues->removeElement($metaValue)) {
            // set the owning side to null (unless already changed)
            if ($metaValue->getMetadata() === $this) {
                $metaValue->setMetadata(null);
            }
        }

        return $this;
    }
}
