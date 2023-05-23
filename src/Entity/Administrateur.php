<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Model\Personne;  
use App\Security\Hasher\SecureHasher;
use App\Entity\AuthEntity;
#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur extends Personne
{

    function __construct(...$args){
        
        if($args==null){$n=0;}
          else{ $n=count($args);}  
          if($n>4){ $secure=  new SecureHasher(); }
          //var_dump($n);
        switch($n){
          case 0 : Parent::__construct(null,"","","");break;
          //$id = null,$Nom,$Prenom,$email
          case 4 : Parent::__construct($args[0]=null,$args[1],$args[2],$args[3]);break;
    
       }
          
    }
    
 
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column]        
    #[ORM\OneToOne( targetEntity:'App\Entity\AuthEntity', mappedBy : 'Administrateur' ,cascade:['persist','remove'])] 
    #[ORM\JoinColumn(name:'authentity_id',referencedColumnName:'id')]  
    private  $AuthEntity =null ;  

    protected ?string $Email;    
    #[ORM\Column] 
    protected ?string $username;  
    #[ORM\Column] 
    protected ?string $password;  
    #[ORM\Column] 
    protected ?string $Nom;
    #[ORM\Column] 
    protected ?string $Prenom;
     
    public function getId(): ?int
    {
        return $this->id;
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
    public function getNom(): ?string
    {
        return $this->Nom; 
    }

    public function setNom(string $nom): self
    {

        $this->Nom=$nom;
     
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom; 
    }

    public function setPrenom(string $prenom): Self
    {
        $this->Prenom=$prenom;
        return $this;
    }

    public function getPassword(): ?string
    {

        return $this->password;
       
    }

    public function setPassword(string $password=null): self
    {   
        if($password!=null){
        $secure=  new SecureHasher();   
        $this->password = $secure->hash($password);
         }else{return $this;}
       
        return $this;
    }  
    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }


    public function getRoles():Array
    {
        return array('ROLE_ADMIN');
        }

    public function eraseCredentials()
    {
    }


   public function __toString(){
        return "Administrateur".$this->getEmail();         
   }

}
