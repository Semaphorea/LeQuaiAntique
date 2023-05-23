<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Model\Personne; 
use App\Entity\AuthEntity; 
use App\Security\Hasher\SecureHasher;
use DateTime;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends Personne
{

    function __construct(...$args){       
        $n=count($args);
        switch ($n) { 
            case 0 ://$this->AuthEntity=new AuthEntity();
            break;

                   //Id, Nom, Prenom, email 
            case 3 :Parent::__construct($id=null, $args[1],$args[2],$args[3]);  
                    $this->AuthEntity= new AuthEntity($id=null,  $args[1],$args[2],$args[3]) ;break;

                    //Id, Nom, Prenom, email
            case 4 :Parent::__construct($args[0],$args[1],$args[2],$args[3]);     
                   $this->AuthEntity= new AuthEntity($args[0],$args[1],$args[2],$args[3]) ;   
                    break;  
  
                    //Id, DateTimeCreation, Nom, Prenom, email   
            case 5 :Parent::__construct($args[0],$args[1],$args[2],$args[3],$args[4]);  
                    $this->AuthEntity= new AuthEntity($args[0],$args[2],$args[3],$args[4],$args[5]) ;  
                    $this->DateTimeCreation=$args[1];  
                    break;          
        }
              
    }
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;    

    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected ?\DateTimeInterface $DateTimeCreation ;

    #[ORM\Column(length: 64)]
    public ?string $Nom ;       //A l'origine en protected : Obligé de mettre en public sinon impossible de flusher les données dans CrudClientController

    #[ORM\Column(length: 64)]
    public ?string $Prenom ; 
 
    #[ORM\Column(length: 64)]
    public ?string $username ; 
   
    protected string $Password;
    protected string $PasswordConfirmation;

    #[ORM\Column]
    public ?int $nbConvive = null;
  
    #[ORM\Column(length: 255)]
    #[ORM\OneToMany( targetEntity:'App\Entity\Commande', mappedBy : 'id' ,cascade:['persist','remove'])]
    public Mixed $Commande = null;
 
    #[ORM\Column(length: 255)]     
    #[ORM\OneToMany( targetEntity:'App\Entity\Reservation', mappedBy : 'Client' ,cascade:['persist','remove'])] 
    public Mixed $Reservation = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)] 
    public array $IntolerancesAlimentaires = []; 
 
     
    #[ORM\Column(nullable: true)]    
    #[ORM\OneToOne( targetEntity:'App\Entity\AuthEntity', mappedBy : 'Client' ,cascade:['persist','remove'])] 
    public Mixed $AuthEntity = null;     
 
    public function getId(): ?int 
    {
        return $this->id;
    }    

    public function getDateTimeCreation(): ?\DateTimeInterface
    {
        return $this->DateTimeCreation;
    }

    public function setDateTimeCreation(?\DateTimeInterface $DateTimeCreation): self
    {

        if($DateTimeCreation!=null){
        $this->DateTimeCreation = $DateTimeCreation;   
        }
        else{$this->DateTimeCreation = new DateTime('now');} 
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;   

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;   

        return $this;
    }
    public function getEmail(): ?string
    {
        return $this->email;  
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNbConvive(): ?int
    {
        return $this->nbConvive;
    }

    public function setNbConvive(int $nbConvive): self
    {
        $this->nbConvive = $nbConvive;

        return $this;
    }

    public function getCommande(): Mixed
    {
        return $this->Commande;
    }

    public function setCommande(Mixed $Commande): self
    {
        $this->Commande = $Commande;

        return $this;
    }  

    public function getIntolerancesAlimentaires(): array
    {
        return $this->IntolerancesAlimentaires;
    }

    public function setIntolerancesAlimentaires( $IntolerancesAlimentaires): self
    {
        if(is_array($IntolerancesAlimentaires)){
        $this->IntolerancesAlimentaires = $IntolerancesAlimentaires;} 
        else{ $this->IntolerancesAlimentaires = explode(',',$IntolerancesAlimentaires);}

        return $this;
    }

    public function getReservation(): Mixed
    {
        return $this->Reservation;
    }

    public function setReservation(Mixed $Reservation): self
    {
        $this->Reservation = $Reservation; 

        return $this;
    }
    
    public function getRoles():Array
    {
        return array('ROLE_USER');
    }

    public function getAuthEntity(): Mixed
    {
        return $this->AuthEntity;
    }

    public function setAuthEntity(AuthEntity $AuthEntity): self
    {
        $this->AuthEntity = $AuthEntity; 

        return $this;
    }


    public function getPassword(){
       
      return  $this->getAuthEntity()->getPassword();

    }  

    public function setPassword(String $password){

        if($password!=null || strlen($password)!=60){
            
            $secure=  new SecureHasher();   
            $this->password = $secure->hash($password);
            $this->getAuthEntity()->setPassword($secure->hash($password));

             }else if(strlen($password)==60){
                $this->getAuthEntity()->setPassword($password);
                $this->password = $password;}
        return  $this;  
    }

    public function getPasswordConfirmation(){

        return  $this->getAuthEntity()->getPasswordConfirmation();
  
      }   
  
      public function setPasswordConfirmation(String $password){
        
        if($password!=null || strlen($password)!=60){
            
            $secure=  new SecureHasher();   
            $this->PasswordConfirmation = $secure->hash($password);
            $this->getAuthEntity()->setPasswordConfirmation($secure->hash($password));

             }else if(strlen($password)==60){
                $this->getAuthEntity()->setPasswordConfirmation($password);
                $this->PasswordConfirmation = $password;}
                return  $this;  
    }

    public function eraseCredentials() 
    {
    }
   

    public function setDatas( $Nom, $Prenom, $email,$nbConvive,$IntolerancesAlimentaires){
           $this->setNom($Nom); 
           $this->setPrenom($Prenom);
           $this->setEmail($email);        
           $this->setNbConvive($nbConvive);
           $this->setIntolerancesAlimentaires($IntolerancesAlimentaires);
    
    }




    public function __toString(): string
    {
        return $this->Nom.' '.$this->Prenom. ' '.$this->email;
    }
  
}
