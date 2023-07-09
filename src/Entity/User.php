<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $matricule = null;

    #[ORM\Column]
    private ?int $idUnique = null;

    #[ORM\Column(length: 255)]
    private ?string $telNumber = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rank $rank = null;

    #[ORM\ManyToMany(targetEntity: Arrestation::class, mappedBy: 'agent')]
    private Collection $arrestations;

    #[ORM\ManyToMany(targetEntity: JudiciaryCase::class, mappedBy: 'magistrate')]
    private Collection $judiciaryCases;


    public function __toString()
    {
        return '[' . $this->getMatricule() .'] '. $this->getFirstname()  . ' '. $this->getLastname();
    }
    public function __construct()
    {
        $this->arrestations = new ArrayCollection();
        $this->judiciaryCases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

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

    public function getTelNumber(): ?string
    {
        return $this->telNumber;
    }

    public function setTelNumber(string $telNumber): self
    {
        $this->telNumber = $telNumber;

        return $this;
    }

    public function getRank(): ?Rank
    {
        return $this->rank;
    }

    public function setRank(?Rank $rank): self
    {
        $this->rank = $rank;

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
            $arrestation->addAgent($this);
        }

        return $this;
    }

    public function removeArrestation(Arrestation $arrestation): self
    {
        if ($this->arrestations->removeElement($arrestation)) {
            $arrestation->removeAgent($this);
        }

        return $this;
    }

//    public function getStats()
//    {
////        dd($this->getArrestations());
////        $b = count($this->getArrestations());
////        dd($b);
//        foreach($this->getArrestations() as $a)
//        {
//            dd($a);
//        }
//
//    }

/**
 * @return Collection<int, JudiciaryCase>
 */
public function getJudiciaryCases(): Collection
{
    return $this->judiciaryCases;
}

public function addJudiciaryCase(JudiciaryCase $judiciaryCase): self
{
    if (!$this->judiciaryCases->contains($judiciaryCase)) {
        $this->judiciaryCases->add($judiciaryCase);
        $judiciaryCase->addMagistrate($this);
    }

    return $this;
}

public function removeJudiciaryCase(JudiciaryCase $judiciaryCase): self
{
    if ($this->judiciaryCases->removeElement($judiciaryCase)) {
        $judiciaryCase->removeMagistrate($this);
    }

    return $this;
}
}
