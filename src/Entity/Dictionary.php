<?php

namespace App\Entity;

use App\Repository\DictionaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=DictionaryRepository::class)
 * @UniqueEntity(fields="name", message="Название словаря должно быть уникальным.")
 */
class Dictionary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Comparison::class, mappedBy="dictionary")
     */
    private $comparisons;

    public function __construct()
    {
        $this->comparisons = new ArrayCollection();
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
     * @return Collection<int, Comparison>
     */
    public function getComparisons(): Collection
    {
        return $this->comparisons;
    }

    public function addComparison(Comparison $comparison): self
    {
        if (!$this->comparisons->contains($comparison)) {
            $this->comparisons[] = $comparison;
            $comparison->setDictionary($this);
        }

        return $this;
    }

    public function removeComparison(Comparison $comparison): self
    {
        if ($this->comparisons->removeElement($comparison)) {
            // set the owning side to null (unless already changed)
            if ($comparison->getDictionary() === $this) {
                $comparison->setDictionary(null);
            }
        }

        return $this;
    }
}
