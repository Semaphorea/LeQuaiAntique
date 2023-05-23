<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $Entree = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $PlatPrincipal = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $Dessert = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $Boisson = [];

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $Menu = [];

    #[ORM\Column]
    private ?float $Prix = null;

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

    public function getPlatPrincipal(): array
    {
        return $this->PlatPrincipal;
    }

    public function setPlatPrincipal(?array $PlatPrincipal): self
    {
        $this->PlatPrincipal = $PlatPrincipal;

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

    public function getBoisson(): array
    {
        return $this->Boisson;
    }

    public function setBoisson(?array $Boisson): self
    {
        $this->Boisson = $Boisson;

        return $this;
    }

    public function getMenu(): array
    {
        return $this->Menu;
    }

    public function setMenu(?array $Menu): self
    {
        $this->Menu = $Menu;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }
}
