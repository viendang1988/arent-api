<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ApiResource]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: NewsTag::class, orphanRemoval: true)]
    private Collection $newsTags;

    public function __construct()
    {
        $this->newsTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, NewsTag>
     */
    public function getNewsTags(): Collection
    {
        return $this->newsTags;
    }

    public function addNewsTag(NewsTag $newsTag): self
    {
        if (!$this->newsTags->contains($newsTag)) {
            $this->newsTags->add($newsTag);
            $newsTag->setTag($this);
        }

        return $this;
    }

    public function removeNewsTag(NewsTag $newsTag): self
    {
        if ($this->newsTags->removeElement($newsTag)) {
            // set the owning side to null (unless already changed)
            if ($newsTag->getTag() === $this) {
                $newsTag->setTag(null);
            }
        }

        return $this;
    }
}
