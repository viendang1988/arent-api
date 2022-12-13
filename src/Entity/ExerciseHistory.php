<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciseHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'exercise-history',
    denormalizationContext: [
        'groups' => ['exercise-history:write', 'datetime:write'],
    ],
    normalizationContext: [
        'groups' => ['exercise-history:read', 'datetime:read'],
    ]
)]
#[ORM\Entity(repositoryClass: ExerciseHistoryRepository::class)]
#[ORM\Table]
#[ORM\HasLifecycleCallbacks]
class ExerciseHistory extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['exercise-history:write','exercise-history:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'exerciseHistories')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['exercise-history:write','exercise-history:read'])]
    private ?Exercise $exercise = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['exercise-history:write','exercise-history:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(['exercise-history:write','exercise-history:read'])]
    private ?int $timer = null;

    #[ORM\Column]
    #[Groups(['exercise-history:write','exercise-history:read'])]
    private ?int $caloriesBurnt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['datetime:write','datetime:read'])]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['datetime:write','datetime:read'])]
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): self
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTimer(): ?int
    {
        return $this->timer;
    }

    public function setTimer(int $timer): self
    {
        $this->timer = $timer;

        return $this;
    }

    public function getCaloriesBurnt(): ?int
    {
        return $this->caloriesBurnt;
    }

    public function setCaloriesBurnt(int $caloriesBurnt): self
    {
        $this->caloriesBurnt = $caloriesBurnt;

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
