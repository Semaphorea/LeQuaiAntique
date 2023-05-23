<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteRepository::class)]
class Carte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $Entree = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $Plat = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $Dessert = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntree(): array
    {
        return $this->Entree;
    }  

    public function setEntree(?array $Entree): self
    {
        $this->Entree = $Entree;

        return $this;
    }

    public function getPlat(): array
    {
        return $this->Plat;
    }

    public function setPlat(?array $Plat): self
    {
        $this->Plat = $Plat;

        return $this;
    }

    public function getDessert(): array
    {
        return $this->Dessert;
    }

    public function setDessert(?array $Dessert): self
    {
        $this->Dessert = $Dessert;

        return $this;
    }
}
