<?php

namespace App\Entity\Model;

use App\Entity\Photo;
use App\Repository\PlatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


abstract class Plat
{


    function __construct($id=null,$Titre,$Description,$Prix, $Photo=null){
        $this->id=$id;
        $this->Titre=$Titre;
        $this->Description=$Description;
        $this->Prix=$Prix;
        $this->Photo=$Photo;

    }

      
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $Titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?float $Prix = null;

    #[ORM\Column]
    private ?Photo $Photo = null;


    
    abstract public function getId(): ?int;
   

    abstract public function getTitre(): ?string;
    abstract function setTitre(string $Titre): self;
   

    abstract public function getDescription(): ?string;
  
    abstract public function setDescription(string $Description): self;
   

    abstract public function getPrix(): ?float;
    
    abstract public function setPrix(float $Prix): self;


    abstract public function getPhoto(): ?Photo;  
  
    abstract public function setPhoto(Photo $Photo): self;
   
  
}
