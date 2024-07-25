<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Rajoute des caractéres', maxMessage: 'Il y a trop de caractéres')]
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Rajoute des caractéres', maxMessage: 'Il y a trop de caractéres')]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\LessThanOrEqual(1440)]
    #[ORM\Column(nullable: true)]
    private ?int $temps = null;

    #[Assert\LessThan(50)]
    #[ORM\Column]
    private ?int $nbPersonne = null;

    #[Assert\Range(min: 1, max: 5)]
    #[ORM\Column]
    private ?int $difficulties = null;

    #[Assert\NotBlank()]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[Assert\LessThan(1000)]
    #[Assert\GreaterThanOrEqual(1)]
    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $prix = null;

    #[ORM\Column]
    private ?bool $favoris = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateOfCreation = null;

    #[ORM\PrePersist]
    public function setDateCreationValue()
    {
        $this->dateOfCreation = new DateTimeImmutable();
    }
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateOfMaj = null;

    /**
     * @var Collection<int, Ingredients>
     */
    #[ORM\ManyToMany(targetEntity: Ingredients::class, inversedBy: 'recipes')]
    private Collection $ingredients;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fileName = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }
    #[ORM\PreUpdate]
    public function setDateMajValue()
    {
        $this->dateOfMaj = new DateTimeImmutable();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(?int $temps): static
    {
        $this->temps = $temps;

        return $this;
    }

    public function getNbPersonne(): ?int
    {
        return $this->nbPersonne;
    }

    public function setNbPersonne(int $nbPersonne): static
    {
        $this->nbPersonne = $nbPersonne;

        return $this;
    }

    public function getDifficulties(): ?int
    {
        return $this->difficulties;
    }

    public function setDifficulties(int $difficulties): static
    {
        $this->difficulties = $difficulties;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function isFavoris(): ?bool
    {
        return $this->favoris;
    }

    public function setFavoris(bool $favoris): static
    {
        $this->favoris = $favoris;

        return $this;
    }

    public function getDateOfCreation(): ?\DateTimeImmutable
    {
        return $this->dateOfCreation;
    }

    public function setDateOfCreation(\DateTimeImmutable $dateOfCreation): static
    {
        $this->dateOfCreation = $dateOfCreation;

        return $this;
    }

    public function getDateOfMaj(): ?\DateTimeImmutable
    {
        return $this->dateOfMaj;
    }

    public function setDateOfMaj(\DateTimeImmutable $dateOfMaj): static
    {
        $this->dateOfMaj = $dateOfMaj;

        return $this;
    }

    /**
     * @return Collection<int, Ingredients>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredients $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredients $ingredient): static
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): static
    {
        $this->fileName = $fileName;

        return $this;
    }
}
