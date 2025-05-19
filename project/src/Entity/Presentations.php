<?php

namespace App\Entity;

use App\Repository\PresentationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresentationsRepository::class)]
class Presentations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Programmations $programmation = null;

    #[ORM\Column(length: 255)]
    private ?string $fichier = null;

    #[ORM\Column]
    private ?\DateTime $uploadeAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgrammation(): ?Programmations
    {
        return $this->programmation;
    }

    public function setProgrammation(?Programmations $programmation): static
    {
        $this->programmation = $programmation;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): static
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getUploadeAt(): ?\DateTime
    {
        return $this->uploadeAt;
    }

    public function setUploadeAt(\DateTime $uploadeAt): static
    {
        $this->uploadeAt = $uploadeAt;

        return $this;
    }
}
