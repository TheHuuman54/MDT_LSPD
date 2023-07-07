<?php

namespace App\Entity;

use App\Repository\JudiciaryCaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JudiciaryCaseRepository::class)]
class JudiciaryCase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'judiciaryCase', targetEntity: Arrestation::class)]
    private Collection $arrestations;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $decision = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'judiciaryCases')]
    private Collection $magistrate;

    #[ORM\OneToOne(inversedBy: 'judiciaryCase', cascade: ['persist', 'remove'])]
    private ?Civil $suspect = null;

    public function __construct()
    {
        $this->arrestations = new ArrayCollection();
        $this->magistrate = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $arrestation->setJudiciaryCase($this);
        }

        return $this;
    }

    public function removeArrestation(Arrestation $arrestation): self
    {
        if ($this->arrestations->removeElement($arrestation)) {
            // set the owning side to null (unless already changed)
            if ($arrestation->getJudiciaryCase() === $this) {
                $arrestation->setJudiciaryCase(null);
            }
        }

        return $this;
    }

    public function getDecision(): ?string
    {
        return $this->decision;
    }

    public function setDecision(?string $decision): self
    {
        $this->decision = $decision;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getMagistrate(): Collection
    {
        return $this->magistrate;
    }

    public function addMagistrate(User $magistrate): self
    {
        if (!$this->magistrate->contains($magistrate)) {
            $this->magistrate->add($magistrate);
        }

        return $this;
    }

    public function removeMagistrate(User $magistrate): self
    {
        $this->magistrate->removeElement($magistrate);

        return $this;
    }

    public function getSuspect(): ?Civil
    {
        return $this->suspect;
    }

    public function setSuspect(?Civil $suspect): self
    {
        $this->suspect = $suspect;

        return $this;
    }
}
