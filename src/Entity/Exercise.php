<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'exercise',
    denormalizationContext: [
        'groups' => ['exercise:write', 'datetime:write'],
    ],
    normalizationContext: [
        'groups' => ['exercise:read', 'datetime:read'],
    ]
)]
#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
#[ORM\Table]
#[ORM\HasLifecycleCallbacks]
class Exercise extends BaseEntity
{
    public const TYPE_SYSTEM = 1;
    public const TYPE_CUSTOM_FOR_USER = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['exercise:write','exercise:read'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['exercise:write','exercise:read'])]
    private ?float $rate = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['exercise:write','exercise:read'])]
    private ?int $type = self::TYPE_SYSTEM;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(name: 'created_by', referencedColumnName: 'id', nullable: true)]
    #[Groups(['exercise:write','exercise:read'])]
    private ?User $createdBy = null;

    #[ORM\OneToMany(mappedBy: 'exercise', targetEntity: ExerciseHistory::class, orphanRemoval: true)]
    private Collection $exerciseHistories;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['datetime:write','datetime:read'])]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['datetime:write','datetime:read'])]
    private $updatedAt;


    public function __construct()
    {
        $this->exerciseHistories = new ArrayCollection();
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

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection<int, ExerciseHistory>
     */
    public function getExerciseHistories(): Collection
    {
        return $this->exerciseHistories;
    }

    public function addExerciseHistory(ExerciseHistory $exerciseHistory): self
    {
        if (!$this->exerciseHistories->contains($exerciseHistory)) {
            $this->exerciseHistories->add($exerciseHistory);
            $exerciseHistory->setExercise($this);
        }

        return $this;
    }

    public function removeExerciseHistory(ExerciseHistory $exerciseHistory): self
    {
        if ($this->exerciseHistories->removeElement($exerciseHistory)) {
            // set the owning side to null (unless already changed)
            if ($exerciseHistory->getExercise() === $this) {
                $exerciseHistory->setExercise(null);
            }
        }

        return $this;
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
