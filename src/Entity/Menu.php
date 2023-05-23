<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;  
use App\Entity\Formule;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]  
    private ?string $Titre = null;  
  
    #[ORM\Column]
    #[ORM\OneToMany(targetEntity:Formule::class,mappedBy:'Menu')]    
    #[ORM\JoinColumn(name:'formule_id',referencedColumnName:'id')]  
    private  $Formule = null;  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getFormule():Mixed
    {
        return $this->Formule;
    }

    public function setFormule(Formule $Formule): self
    {
        $this->Formule = $Formule;

        return $this;
    }
}
