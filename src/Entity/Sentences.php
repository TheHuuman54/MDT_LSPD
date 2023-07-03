<?php

namespace App\Entity;

use App\Repository\SentencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SentencesRepository::class)]
class Sentences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $article = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $money = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Arrestation::class, mappedBy: 'sentences')]
    private Collection $arrestations;

    #[ORM\Column(nullable: true)]
    private ?int $gavTime = null;

    #[ORM\Column(nullable: true)]
    private ?bool $avocat = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Procureur = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Judge = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $action = null;

    public function __construct()
    {
        $this->arrestations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName() . ' ('. $this->getCategory()->getName() . ')';
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(string $article): self
    {
        $this->article = $article;

        return $this;
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

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(int $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $arrestation->addSentence($this);
        }

        return $this;
    }

    public function removeArrestation(Arrestation $arrestation): self
    {
        if ($this->arrestations->removeElement($arrestation)) {
            $arrestation->removeSentence($this);
        }

        return $this;
    }

    public function getGavTime(): ?int
    {
        return $this->gavTime;
    }

    public function setGavTime(?int $gavTime): self
    {
        $this->gavTime = $gavTime;

        return $this;
    }

    public function isAvocat(): ?bool
    {
        return $this->avocat;
    }

    public function setAvocat(?bool $avocat): self
    {
        $this->avocat = $avocat;

        return $this;
    }

    public function isProcureur(): ?bool
    {
        return $this->Procureur;
    }

    public function setProcureur(?bool $Procureur): self
    {
        $this->Procureur = $Procureur;

        return $this;
    }

    public function isJudge(): ?bool
    {
        return $this->Judge;
    }

    public function setJudge(?bool $Judge): self
    {
        $this->Judge = $Judge;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): self
    {
        $this->action = $action;

        return $this;
    }
}
