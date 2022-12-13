<?php

namespace App\Entity;

use App\Repository\MealHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[\ApiPlatform\Core\Annotation\ApiResource(
    shortName: 'meal-history',
    denormalizationContext: [
        'groups' => ['meal-history:write', 'datetime:write'],
    ],
    normalizationContext: [
        'groups' => ['meal-history:read', 'datetime:read'],
    ]
)]
#[ORM\Entity(repositoryClass: MealHistoryRepository::class)]
#[ORM\Table]
#[ORM\HasLifecycleCallbacks]
class MealHistory extends BaseEntity
{
    public const DATE_SESSION_MORNING = 1;
    public const DATE_SESSION_LUNCH = 2;
    public const DATE_SESSION_DINNER = 3;
    public const DATE_SESSION_SNACK = 4;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['meal-history:write','meal-history:read'])]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['meal-history:write','meal-history:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['meal-history:write','meal-history:read'])]
    private ?int $dateSession = self::DATE_SESSION_MORNING;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['meal-history:write','meal-history:read'])]
    private ?string $image = null;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDateSession(): ?int
    {
        return $this->dateSession;
    }

    public function setDateSession(int $dateSession): self
    {
        $this->dateSession = $dateSession;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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
