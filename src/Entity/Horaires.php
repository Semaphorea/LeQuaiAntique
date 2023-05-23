<?php

namespace App\Entity;

use App\Repository\HorairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HorairesRepository::class)]
class Horaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DejeunerDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DejeunerFin = null;  

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DinerDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DinerFin = null;

    #[ORM\Column]
    private bool $active = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDejeunerDebut(): ?\DateTimeInterface
    {
        return $this->DejeunerDebut;
    }

    public function setDejeunerDebut(\DateTimeInterface $DejeunerDebut): self
    {
        $this->DejeunerDebut = $DejeunerDebut;

        return $this;
    }

    public function getDejeunerFin(): ?\DateTimeInterface
    {
        return $this->DejeunerFin;
    }

    public function setDejeunerFin(\DateTimeInterface $DejeunerFin): self
    {
        $this->DejeunerFin = $DejeunerFin;

        return $this;
    }


    public function getDinerDebut(): ?\DateTimeInterface
    {
        return $this->DinerDebut;
    }

    public function setDinerDebut(\DateTimeInterface $DinerDebut): self
    {
        $this->DinerDebut = $DinerDebut;

        return $this;
    }

    public function getDinerFin(): ?\DateTimeInterface
    {
        return $this->DinerFin;
    }

    public function setDinerFin(\DateTimeInterface $DinerFin): self
    {
        $this->DinerFin = $DinerFin;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;   

        return $this;
    }
}
