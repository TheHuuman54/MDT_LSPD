<?php

namespace App\Entity;

use App\Repository\CivilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CivilRepository::class)]
class Civil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(nullable: true)]
    private ?int $height = null;

    #[ORM\Column]
    private ?int $idUnique = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telNumber = null;

    #[ORM\OneToMany(mappedBy: 'civil', targetEntity: Pictures::class, cascade: ['persist'],orphanRemoval: true)]
    private Collection $documents;

    #[ORM\OneToMany(mappedBy: 'suspect', targetEntity: Arrestation::class, cascade: ['persist'],orphanRemoval: true)]
    private Collection $arrestations;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->arrestations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getIdUnique(): ?int
    {
        return $this->idUnique;
    }

    public function setIdUnique(int $idUnique): self
    {
        $this->idUnique = $idUnique;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getTelNumber(): ?string
    {
        return $this->telNumber;
    }

    public function setTelNumber(?string $telNumber): self
    {
        $this->telNumber = $telNumber;

        return $this;
    }

    /**
     * @return Collection<int, Pictures>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Pictures $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setCivil($this);
        }

        return $this;
    }

    public function removeDocument(Pictures $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getCivil() === $this) {
                $document->setCivil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Arrestation>
     */
    public function getArrestations(): Collection
    {
        return $this->arrestations;
    }

    public function addArrestation(Arrestation $arrestation): self
    {
        if (!$this->arrestations->contains($arrestation)) {
            $this->arrestations->add($arrestation);
            $arrestation->setSuspect($this);
        }

        return $this;
    }

    public function removeArrestation(Arrestation $arrestation): self
    {
        if ($this->arrestations->removeElement($arrestation)) {
            // set the owning side to null (unless already changed)
            if ($arrestation->getSuspect() === $this) {
                $arrestation->setSuspect(null);
            }
        }

        return $this;
    }
}
