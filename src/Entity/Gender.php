<?php

namespace App\Entity;

use App\Repository\GenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenderRepository::class)]
class Gender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'gender', targetEntity: Civil::class)]
    private Collection $civils;

    public function __toString()
    {
        return $this->getName();
    }
    public function __construct()
    {
        $this->civils = new ArrayCollection();
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
     * @return Collection<int, Civil>
     */
    public function getCivils(): Collection
    {
        return $this->civils;
    }

    public function addCivil(Civil $civil): self
    {
        if (!$this->civils->contains($civil)) {
            $this->civils->add($civil);
            $civil->setGender($this);
        }

        return $this;
    }

    public function removeCivil(Civil $civil): self
    {
        if ($this->civils->removeElement($civil)) {
            // set the owning side to null (unless already changed)
            if ($civil->getGender() === $this) {
                $civil->setGender(null);
            }
        }

        return $this;
    }
}
