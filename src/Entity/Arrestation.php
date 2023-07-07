<?php

namespace App\Entity;

use App\Repository\ArrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArrestationRepository::class)]
class Arrestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $gavStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $gavEnd = null;

    #[ORM\OneToMany(mappedBy: 'arrestation', targetEntity: Pictures::class, cascade: ['persist'],orphanRemoval: true)]
    private Collection $justicePicture;

    #[ORM\ManyToMany(targetEntity: Sentences::class, inversedBy: 'arrestations')]
    private Collection $sentences;

    #[ORM\ManyToOne(inversedBy: 'arrestations')]
    private ?Civil $suspect = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'arrestations')]
    private Collection $agent;

    #[ORM\ManyToOne(inversedBy: 'arrestations')]
    private ?JudiciaryCase $judiciaryCase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $saisis = null;

    public function __construct()
    {
        $this->justicePicture = new ArrayCollection();
        $this->sentences = new ArrayCollection();
        $this->agent = new ArrayCollection();
    }

    public function __toString()
    {
        return 'Arrestation du : '. $this->getDate()->format('d/m/Y à H:m'). ' de '. $this->getSuspect();
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

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getGavStart(): ?\DateTimeInterface
    {
        return $this->gavStart;
    }

    public function setGavStart(\DateTimeInterface $gavStart): self
    {
        $this->gavStart = $gavStart;

        return $this;
    }

    public function getGavEnd(): ?\DateTimeInterface
    {
        return $this->gavEnd;
    }

    public function setGavEnd(\DateTimeInterface $gavEnd): self
    {
        $this->gavEnd = $gavEnd;

        return $this;
    }

    /**
     * @return Collection<int, Pictures>
     */
    public function getJusticePicture(): Collection
    {
        return $this->justicePicture;
    }

    public function addJusticePicture(Pictures $justicePicture): self
    {
        if (!$this->justicePicture->contains($justicePicture)) {
            $this->justicePicture->add($justicePicture);
            $justicePicture->setArrestation($this);
        }

        return $this;
    }

    public function removeJusticePicture(Pictures $justicePicture): self
    {
        if ($this->justicePicture->removeElement($justicePicture)) {
            // set the owning side to null (unless already changed)
            if ($justicePicture->getArrestation() === $this) {
                $justicePicture->setArrestation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sentences>
     */
    public function getSentences(): Collection
    {
        return $this->sentences;
    }

    public function addSentence(Sentences $sentence): self
    {
        if (!$this->sentences->contains($sentence)) {
            $this->sentences->add($sentence);
        }

        return $this;
    }

    public function removeSentence(Sentences $sentence): self
    {
        $this->sentences->removeElement($sentence);

        return $this;
    }

    public function getAllSentences()
    {
        $sentence = $this->sentences;
        $allSentences = [];

        foreach ($sentence as $s)
        {
            $allSentences[] = $s;
        }
        return $allSentences;
    }

    public function getAllMoneySentences()
    {
        $sentence = $this->sentences;
        $totalMoneySentence = null;

        foreach ($sentence as $s)
        {
            $totalMoneySentence += $s->getMoney();
        }

        return $totalMoneySentence;
    }

    public function getAllGavTime()
    {
        $sentence = $this->sentences;
        $totalGavTime = null;

        foreach ($sentence as $s)
        {
            $totalGavTime += $s->getGavTime();
        }
        return $totalGavTime;
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

    /**
     * @return Collection<int, User>
     */
    public function getAgent(): Collection
    {
        return $this->agent;
    }

    public function addAgent(User $agent): self
    {
        if (!$this->agent->contains($agent)) {
            $this->agent->add($agent);
        }

        return $this;
    }

    public function removeAgent(User $agent): self
    {
        $this->agent->removeElement($agent);

        return $this;
    }

    public function fixJusticePicture()
    {
        $da = [];
        foreach($this->getJusticePicture() as $d)
        {
            $da[]= $d;
        }

        if(empty($da))
        {
            $da = null;
        } else {
            return $da;
        }
    }

    public function getJudiciaryCase(): ?JudiciaryCase
    {
        return $this->judiciaryCase;
    }

    public function setJudiciaryCase(?JudiciaryCase $judiciaryCase): self
    {
        $this->judiciaryCase = $judiciaryCase;

        return $this;
    }

    public function countTotalSentence(): int
    {
        return count($this->getSentences());
    }

    public function getSaisis(): ?string
    {
        return $this->saisis;
    }

    public function setSaisis(?string $saisis): self
    {
        $this->saisis = $saisis;

        return $this;
    }

}
