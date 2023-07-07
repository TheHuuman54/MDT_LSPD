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

    #[ORM\ManyToOne(inversedBy: 'civils')]
    private ?Ethnie $type = null;

    #[ORM\ManyToOne(inversedBy: 'civils')]
    private ?Gender $gender = null;

    #[ORM\Column(nullable: true)]
    private ?bool $PPA = null;

    #[ORM\Column(nullable: true)]
    private ?bool $driveCard = null;

    #[ORM\OneToOne(mappedBy: 'suspect', cascade: ['persist', 'remove'])]
    private ?JudiciaryCase $judiciaryCase = null;

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

    public function getTotalArrestations()
    {
        $totalArrestation = count($this->getArrestations());
        return $totalArrestation;
    }

    public function getType(): ?Ethnie
    {
        return $this->type;
    }

    public function setType(?Ethnie $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function fixPicture()
    {
        $da = [];
        foreach($this->getDocuments() as $d)
        {
            $da[]= $d;
        }
        if(empty($da))
        {
            $da = null;
        } else {
            return $da;
        }
        return $da;
    }

    public function isPPA(): ?bool
    {
        return $this->PPA;
    }

    public function setPPA(?bool $PPA): self
    {
        $this->PPA = $PPA;

        return $this;
    }

    public function isDriveCard(): ?bool
    {
        return $this->driveCard;
    }

    public function setDriveCard(?bool $driveCard): self
    {
        $this->driveCard = $driveCard;

        return $this;
    }

    public function checkPPA()
    {
        if($this->isPPA())
        {
            return 'Valide';
        } else {
            return 'Invalide';
        }
    }

    public function checkDriveCard()
    {
        if($this->isDriveCard())
        {
            return 'Valide';
        } else {
            return 'Invalide';
        }
    }

    public function getJudiciaryCase(): ?JudiciaryCase
    {
        return $this->judiciaryCase;
    }

    public function setJudiciaryCase(?JudiciaryCase $judiciaryCase): self
    {
        // unset the owning side of the relation if necessary
        if ($judiciaryCase === null && $this->judiciaryCase !== null) {
            $this->judiciaryCase->setSuspect(null);
        }

        // set the owning side of the relation if necessary
        if ($judiciaryCase !== null && $judiciaryCase->getSuspect() !== $this) {
            $judiciaryCase->setSuspect($this);
        }

        $this->judiciaryCase = $judiciaryCase;

        return $this;
    }

    public function getAllMoneySentence()
    {
        $money = null;
        foreach($this->getArrestations() as $a)
            {
                $money += $a->getAllMoneySentences();
            }
        $inputString = $money;
        $pattern = '/(?<=\d)(?=(\d{3})+(?!\d))/';
        $replacement = ' ';
        $outputString = preg_replace($pattern, $replacement, $inputString);

        return $outputString;
    }
}
