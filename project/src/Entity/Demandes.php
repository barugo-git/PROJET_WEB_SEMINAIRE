<?php

namespace App\Entity;

use App\Repository\DemandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandesRepository::class)]
class Demandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    #[ORM\Column(length: 255)]
    private ?string $theme = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateValidation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateSouhaitee = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateSoumission = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $resume = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(targetEntity: Programmations::class, mappedBy: 'demande')]
    private Collection $programmations;

    #[ORM\ManyToOne(targetEntity: Users::class)]
    private ?Users $presenter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $topic = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $presentation_date = null;
    
    public function __construct()
{
    $this->programmations = new ArrayCollection();
    $this->statut = 'en attente';
}

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->dateValidation;
    }

    public function setDateValidation(?\DateTimeInterface $dateValidation): static
    {
        $this->dateValidation = $dateValidation;
        return $this;
    }

    public function getDateSouhaitee(): ?\DateTimeInterface
    {
        return $this->dateSouhaitee;
    }

    public function setDateSouhaitee(?\DateTimeInterface $dateSouhaitee): static
    {
        $this->dateSouhaitee = $dateSouhaitee;
        return $this;
    }

    public function getDateSoumission(): ?\DateTimeInterface
    {
        return $this->dateSoumission;
    }

    public function setDateSoumission(\DateTimeInterface $dateSoumission): static
    {
        $this->dateSoumission = $dateSoumission;
        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): static
    {
        $this->resume = $resume;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getProgrammations(): Collection
    {
        return $this->programmations;
    }

    public function addProgrammation(Programmations $programmation): static
    {
        if (!$this->programmations->contains($programmation)) {
            $this->programmations->add($programmation);
            $programmation->setDemande($this);
        }
        return $this;
    }

    public function removeProgrammation(Programmations $programmation): static
    {
        if ($this->programmations->removeElement($programmation)) {
            if ($programmation->getDemande() === $this) {
                $programmation->setDemande(null);
            }
        }
        return $this;
    }

    public function getPresenter(): ?Users
    {
        return $this->presenter;
    }

    public function setPresenter(?Users $presenter): static
    {
        $this->presenter = $presenter;
        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(?string $topic): static
    {
        $this->topic = $topic;
        return $this;
    }

    public function getPresentationDate(): ?\DateTimeInterface
    {
        return $this->presentation_date;
    }

    public function setPresentationDate(?\DateTimeInterface $presentation_date): static
    {
        $this->presentation_date = $presentation_date;
        return $this;
    }
    public function getPresentationCount(): int
{
    // Ici on compte par exemple le nombre d’éléments dans la collection programmations
    return $this->programmations->count();
}

}
