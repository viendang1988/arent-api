<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'news',
    denormalizationContext: [
        'groups' => ['news:write', 'datetime:write'],
    ],
    normalizationContext: [
        'groups' => ['news:read', 'datetime:read'],
    ]
)]
#[ORM\Entity(repositoryClass: NewsRepository::class)]
#[ORM\Table]
#[ORM\HasLifecycleCallbacks]
class News extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['news:write','news:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['news:write','news:read'])]
    private $content = null;

    #[ORM\ManyToOne(inversedBy: 'news')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['news:write','news:read'])]
    private ?NewsCategory $category = null;

    #[ORM\OneToMany(mappedBy: 'news', targetEntity: NewsTag::class, orphanRemoval: true)]
    private Collection $newsTags;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['datetime:write','datetime:read'])]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['datetime:write','datetime:read'])]
    private $updatedAt;

    public function __construct()
    {
        $this->newsTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?NewsCategory
    {
        return $this->category;
    }

    public function setCategory(?NewsCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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
            $newsTag->setNews($this);
        }

        return $this;
    }

    public function removeNewsTag(NewsTag $newsTag): self
    {
        if ($this->newsTags->removeElement($newsTag)) {
            // set the owning side to null (unless already changed)
            if ($newsTag->getNews() === $this) {
                $newsTag->setNews(null);
            }
        }

        return $this;
    }

    /**
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param null $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }




}
