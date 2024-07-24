<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[UniqueEntity('name')]
#[HasLifecycleCallbacks]
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
    #[ORM\Column]
    private ?int $time = null;

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
    private ?\DateTimeImmutable $dateOfcreation = null;


    #[ORM\PrePersist]
    public function setDateCreationValue()
    {
        $this->dateOfcreation = new DateTimeImmutable();
    }

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateOfmaj = null;

    /**
     * @var Collection<int, Recette>
     */
    #[ORM\ManyToMany(targetEntity: Recette::class)]
    #[ORM\JoinColumn(onDelete: "SET NULL")]
    private Collection $Ingredients;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fileName = null;

    public function __construct()
    {
        $this->Ingredients = new ArrayCollection();
    }

    #[ORM\PreUpdate]
    public function setDateMajValue()
    {
        $this->dateOfmaj = new DateTimeImmutable();
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

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): static
    {
        $this->time = $time;

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



    /**
     * Get the value of nbPersonne
     */
    public function getNbPersonne()
    {
        return $this->nbPersonne;
    }

    /**
     * Set the value of nbPersonne
     *
     * @return  self
     */
    public function setNbPersonne($nbPersonne)
    {
        $this->nbPersonne = $nbPersonne;

        return $this;
    }

    /**
     * Get the value of dateOfcreation
     */
    public function getDateOfcreation()
    {
        return $this->dateOfcreation;
    }

    /**
     * Set the value of dateOfcreation
     *
     * @return  self
     */
    public function setDateOfcreation($dateOfcreation)
    {
        $this->dateOfcreation = $dateOfcreation;

        return $this;
    }

    /**
     * Get the value of dateOfmaj
     */
    public function getDateOfmaj()
    {
        return $this->dateOfmaj;
    }

    /**
     * Set the value of dateOfmaj
     *
     * @return  self
     */
    public function setDateOfmaj($dateOfmaj)
    {
        $this->dateOfmaj = $dateOfmaj;

        return $this;
    }

    /**
     * @return Collection<int, Recette>
     */
    public function getIngredients(): Collection
    {
        return $this->Ingredients;
    }

    public function addIngredient(Recette $ingredient): static
    {
        if (!$this->Ingredients->contains($ingredient)) {
            $this->Ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Recette $ingredient): static
    {
        $this->Ingredients->removeElement($ingredient);

        return $this;
    }

    /**
     * Get the value of fileName
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     *
     * @return  self
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }
}
