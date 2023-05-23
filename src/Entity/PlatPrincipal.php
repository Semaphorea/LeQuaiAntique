<?php

namespace App\Entity;

use App\Entity\Model\Plat;  
use App\Repository\PlatPrincipalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatPrincipalRepository::class)]
class PlatPrincipal extends Plat
{


    function __construct(...$args){
        
        if($args==null){$n=0;}
          else{ $n=count($args);}  
        
        switch($n){
          case 0 : Parent::__construct(null,null,null,null,null);
          break;
            //$id=null,$Titre,$Description,$Prix,$Photo=null
          case 5 :  Parent::__construct($args[0]=null,$args[1],$args[2],$args[3],$args[4]=null);
            break;

     } } 
  
    #[ORM\Id]
    #[ORM\GeneratedValue] 
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]  
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;  

    #[ORM\Column]
    #[ORM\OneToOne(targetEntity:Photo::class)] 
    #[ORM\JoinColumn(name:'photo_id',referencedColumnName:'id')]  
    private  $photo = null;
 


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPhoto(): ?Photo
    { return $this->photo;}  
  
    public function setPhoto(Photo $photo): self
    {
        $this->photo=$photo;
    
        return $this;
    }  
}
