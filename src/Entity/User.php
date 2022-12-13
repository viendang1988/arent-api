<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'user',
    denormalizationContext: [
        'groups' => ['user:write', 'datetime:write'],
    ],
    normalizationContext: [
        'groups' => ['user:read', 'datetime:read'],
    ]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table('user')]
#[ORM\Index(columns: ['email'], name: 'uuid_idx')]
#[UniqueEntity('email', message: 'This email is already used')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const CURRENT_GOAL_LOSE_WEIGHT = 1;
    public const CURRENT_GOAL_MAINTAIN_WEIGHT = 2;
    public const CURRENT_GOAL_GAIN_WEIGHT = 3;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['user:write','user:read'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    #[Groups(['user:write','user:read'])]
    private ?string $lastName = null;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    #[Assert\NotBlank(message: 'assert.generic.not-blank')]
    #[Assert\Email(message: 'assert.generic.email')]
    #[Groups(['user:write','user:read','user:item:patch'])]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['user:write','user:read'])]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column]
    #[Groups(['user:write','user:read'])]
    private ?float $currentWeight = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['user:write','user:read'])]
    private ?int $currentGoal = self::CURRENT_GOAL_LOSE_WEIGHT;

    #[ORM\Column]
    #[Groups(['user:write','user:read'])]
    private ?float $goalWeight = null;

    #[ORM\Column]
    #[Groups(['user:write','user:read'])]
    private ?float $height = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['user:write','user:read'])]
    private ?int $gender = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password;

    #[SerializedName('password')]
    #[Groups(['user:write'])]
    #[Assert\NotBlank(message: 'assert.generic.not-blank', groups: ['Default'])]
    private ?string $plainPassword;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserGoal::class, orphanRemoval: true)]
    private Collection $userGoals;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: NewsCategory::class, orphanRemoval: true)]
    private  $newsCategories;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: News::class, orphanRemoval: true)]
    private Collection $news;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: MealHistory::class, orphanRemoval: true)]
    private Collection $mealHistories;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Exercise::class)]
    private Collection $exercises;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ExerciseHistory::class, orphanRemoval: true)]
    private Collection $exerciseHistories;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Diary::class, orphanRemoval: true)]
    private Collection $diaries;

    public function __construct()
    {
        $this->userGoals = new ArrayCollection();
        $this->newsCategories = new ArrayCollection();
        $this->news = new ArrayCollection();
        $this->mealHistories = new ArrayCollection();
        $this->exercises = new ArrayCollection();
        $this->exerciseHistories = new ArrayCollection();
        $this->diaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCurrentWeight(): ?float
    {
        return $this->currentWeight;
    }

    public function setCurrentWeight(float $currentWeight): self
    {
        $this->currentWeight = $currentWeight;

        return $this;
    }

    public function getCurrentGoal(): ?int
    {
        return $this->currentGoal;
    }

    public function setCurrentGoal(int $currentGoal): self
    {
        $this->currentGoal = $currentGoal;

        return $this;
    }

    public function getGoalWeight(): ?float
    {
        return $this->goalWeight;
    }

    public function setGoalWeight(float $goalWeight): self
    {
        $this->goalWeight = $goalWeight;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, UserGoal>
     */
    public function getUserGoals(): Collection
    {
        return $this->userGoals;
    }

    public function addUserGoal(UserGoal $userGoal): self
    {
        if (!$this->userGoals->contains($userGoal)) {
            $this->userGoals->add($userGoal);
            $userGoal->setUser($this);
        }

        return $this;
    }

    public function removeUserGoal(UserGoal $userGoal): self
    {
        if ($this->userGoals->removeElement($userGoal)) {
            // set the owning side to null (unless already changed)
            if ($userGoal->getUser() === $this) {
                $userGoal->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NewsCategory>
     */
    public function getNewsCategories(): Collection
    {
        return $this->newsCategories;
    }

    public function addNewsCategory(NewsCategory $newsCategory): self
    {
        if (!$this->newsCategories->contains($newsCategory)) {
            $this->newsCategories->add($newsCategory);
            $newsCategory->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNewsCategory(NewsCategory $newsCategory): self
    {
        if ($this->newsCategories->removeElement($newsCategory)) {
            // set the owning side to null (unless already changed)
            if ($newsCategory->getCreatedBy() === $this) {
                $newsCategory->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, News>
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): self
    {
        if (!$this->news->contains($news)) {
            $this->news->add($news);
            $news->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->removeElement($news)) {
            // set the owning side to null (unless already changed)
            if ($news->getCreatedBy() === $this) {
                $news->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MealHistory>
     */
    public function getMealHistories(): Collection
    {
        return $this->mealHistories;
    }

    public function addMealHistory(MealHistory $mealHistory): self
    {
        if (!$this->mealHistories->contains($mealHistory)) {
            $this->mealHistories->add($mealHistory);
            $mealHistory->setUser($this);
        }

        return $this;
    }

    public function removeMealHistory(MealHistory $mealHistory): self
    {
        if ($this->mealHistories->removeElement($mealHistory)) {
            // set the owning side to null (unless already changed)
            if ($mealHistory->getUser() === $this) {
                $mealHistory->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Exercise>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): self
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
            $exercise->setCreatedBy($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): self
    {
        if ($this->exercises->removeElement($exercise)) {
            // set the owning side to null (unless already changed)
            if ($exercise->getCreatedBy() === $this) {
                $exercise->setCreatedBy(null);
            }
        }

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
            $exerciseHistory->setUser($this);
        }

        return $this;
    }

    public function removeExerciseHistory(ExerciseHistory $exerciseHistory): self
    {
        if ($this->exerciseHistories->removeElement($exerciseHistory)) {
            // set the owning side to null (unless already changed)
            if ($exerciseHistory->getUser() === $this) {
                $exerciseHistory->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Diary>
     */
    public function getDiaries(): Collection
    {
        return $this->diaries;
    }

    public function addDiary(Diary $diary): self
    {
        if (!$this->diaries->contains($diary)) {
            $this->diaries->add($diary);
            $diary->setUser($this);
        }

        return $this;
    }

    public function removeDiary(Diary $diary): self
    {
        if ($this->diaries->removeElement($diary)) {
            // set the owning side to null (unless already changed)
            if ($diary->getUser() === $this) {
                $diary->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }


    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
