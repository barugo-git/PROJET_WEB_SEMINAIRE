<?php

namespace App\Entity;

use App\Repository\ProgrammationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammationsRepository::class)]
class Programmations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'programmations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Demandes $demande = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateSeminaire = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $resume = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemande(): ?Demandes
    {
        return $this->demande;
    }

    public function setDemande(?Demandes $demande): static
    {
        $this->demande = $demande;

        return $this;
    }

    public function getDateSeminaire(): ?\DateTime
    {
        return $this->dateSeminaire;
    }

    public function setDateSeminaire(\DateTime $dateSeminaire): static
    {
        $this->dateSeminaire = $dateSeminaire;

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
}
