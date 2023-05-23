<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;
use DateTime;
use App\Repository\ReservationRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    private EntityManagerInterface $entityManager;
      
    function __construct(...$args)
    {
        $n=count($args);
        switch ($n) {
            case 0: break;
            
            case 1: $this->entityManager = $args[0];                
                    break;
        }
    }  
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;  
    
    #[ORM\OneToOne(targetEntity:Client::class, inversedBy:'Reservation')]
    #[ORM\Column]
    public Client $Client;

    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $DateHeureReservation;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $Arrivee = null;

    #[ORM\Column]
    public?int $Nombre_Adultes = null; 
    
    #[ORM\Column(nullable: true)]
    public ?int $Nombre_Enfants = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $horaire_midi = null;  

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $horaire_soir = null;  

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    public ?array $IntolerancesAlimentaires = [];  

    #[ORM\Column]
    public ?String $Remarques = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

  
    public function setClient(Client $Client){
      
         $this->Client= $Client;
        
    }   

    public function getClient(){
         return $this->Client;  
    }

    public function getNombre_Adultes(): ?int
    {
        return $this->Nombre_Adultes;
    }
    public function setNombre_Adultes(int $Nombre_Adultes): self   
    {
        $this->Nombre_Adultes = $Nombre_Adultes;

        return $this;
    }
    public function getNombre_Enfants(): ?int
    {
        return $this->Nombre_Enfants;
    }

    public function setNombre_Enfants(int $Nombre_Enfants): self
    {
        $this->Nombre_Enfants = $Nombre_Enfants;

        return $this;
    }


    public function getDateHeureReservation(): ?\DateTimeInterface
    {
        return $this->DateHeureReservation;
    }

    public function setDateHeureReservation(\DateTimeInterface $DateHeureReservation): self
    {
        $this->DateHeureReservation = $DateHeureReservation;  

        return $this;  
    }

    public function getArrivee(): ?\DateTimeInterface
    {
        return $this->Arrivee;
    }

    public function setArrivee(\DateTimeInterface $Arrivee): self
    {
        $this->Arrivee = $Arrivee;  

        return $this;
    }

  
   function getHoraireMidi(): ?\DateTimeInterface
    {
        return $this->horaire_midi;
    }

    public function setHoraireMidi(String $horaire_midi): self
    {
          var_export($horaire_midi);
          
         $a=new DateTime() ;
         $a->setTime(substr($horaire_midi,0,2),substr($horaire_midi,3,2));
        $this->horaire_midi= $a;

        return $this;
    }

    public function getHoraireSoir(): ?\DateTimeInterface
    { 
        return $this->horaire_soir;
    }



    public function setHoraireSoir(String $horaire_soir): self
    {
          var_export($horaire_soir);
          
         $a=new DateTime() ;
         $a->setTime(substr($horaire_soir,0,2),substr($horaire_soir,3,2));
        $this->horaire_soir= $a;

        return $this;
    }
   

    public function getRemarques(): ?String
    {
        return $this->Remarques;
    }

    public function setRemarques(String $Remarques): self
    {
        $this->Remarques = $Remarques; 

        return $this;
    } 
   
   
    public function getIntolerancesAlimentaires(): array
    {
        return $this->IntolerancesAlimentaires;
    }

    public function setIntolerancesAlimentaires(?array $IntolerancesAlimentaires): self
    {
        $this->IntolerancesAlimentaires = $IntolerancesAlimentaires;

        return $this;
    }


    public function setData($Nombre_Adultes,$Nombre_Enfants,$Arrivee,$horaire_midi,$horaire_soir,$Remarques,$IntolerancesAlimentaires){
        $this->Nombre_Adultes=$Nombre_Adultes;
        $this->Nombre_Enfants=$Nombre_Enfants;
        $this->DateHeureReservation= new DateTime('now') ; 
        $this->Arrivee=$Arrivee;
        $this->horaire_midi=$horaire_midi ;
        $this->horaire_soir =$horaire_soir ;
        $this->Remarques =$Remarques ;
        $this->IntolerancesAlimentaires=$IntolerancesAlimentaires ;    
    }


}
