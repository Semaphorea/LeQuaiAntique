<?php

namespace App\Entity;

use App\Repository\AuthEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Model\Personne;
use App\Entity\Client;
use App\Security\Hasher\SecureHasher;
use Doctrine\DBAL\Types\JsonType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;  
use Symfony\Component\Serializer\Serializer;


#[ORM\Entity(repositoryClass: AuthEntityRepository::class)]
class AuthEntity extends Personne implements UserInterface, PasswordAuthenticatedUserInterface
{
    
    public function __construct(...$args){       
        if ($args==null){$n=0;}
        $n=count($args);
        if($n>4){ $secure=  new SecureHasher(); }
        switch ($n) {
            case 0 : Parent::__construct(null,null,null,null);break;  

            // __construct($id,$nom,$prenom,$email)
            case 4 : Parent::__construct($args[0],$args[1],$args[2],$args[3]);break;  
            // __construct($id,$nom,$prenom,$email,$password) 
            case 5 : Parent::__construct($args[0],$args[1],$args[2],$args[3],$secure->hash($args[4]));break;     
            // __construct($id,$nom,$prenom,$email,$password,$passwordconfirmation)
            case 6 : Parent::__construct($args[0],$args[1],$args[2],$args[3],$secure->hash($args[4])); 
                    $this->passwordconfirmation=$secure->hash($args[5]);break;      
        }
    }
    
    
       
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column] 
    protected array $roles = [];
      

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    protected ?string $password = null;

    /**
    * @var string The hashed passwordconfirmation  
    */
    #[ORM\Column]
    protected ?string $passwordconfirmation = null;  
 

    protected ?string $nom;
    

    protected ?string $prenom;   

    #[ORM\Column]
    protected ?string $username;

    #[ORM\Column] 
    public ?string $email;
         
  
   

    #[ORM\Column]
    #[ORM\OneToOne( targetEntity:'App\Entity\Client', inversedBy : 'AuthEntity' ,cascade:['persist','remove'])]  
    protected ?Client $Client =null ;   
    
    #[ORM\Column]
    #[ORM\OneToOne( targetEntity:'App\Entity\Administrateur', inversedBy : 'AuthEntity' ,cascade:['persist','remove'])] 
    protected $Administrateur =null ; 


    public function getId(): ?int
    {
        return $this->id;
    }  

    public function setId(string $id): self
    {
        $this->id = $id;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->id;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles($roles): self
    {
 
        if(is_string($roles)){$this->roles = array($roles);}
        else{$this->roles = $roles;}

        return $this;
    }
  
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string 
    {      
        return $this->password;
    }

    public function setPassword(string $password=null): self
    {   
        if($password!=null || strlen($password)!=60){
            
        $secure=  new SecureHasher();   
        $this->password = $secure->hash($password);
         }else if(strlen($password)==60){$this->password = $password;}
       
       
        return $this;
    }  
       
    public function getPasswordConfirmation(): ?string 
    {

        return $this->passwordconfirmation;    
    }
  
    public function setPasswordConfirmation(string $passwordconfirmation=null): self
    {    

        if($passwordconfirmation!=null || strlen($passwordconfirmation)!=60){
            
        $secure=  new SecureHasher();   
        $this->passwordconfirmation = $secure->hash($passwordconfirmation);
         }else if(strlen($passwordconfirmation)==60){$this->passwordconfirmation = $passwordconfirmation;}
       

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(string $Client): self
    {
        $this->Client = $Client;

        return $this;
    }
    
    public function getAdministrateur(): ?Administrateur
    {
        return $this->Administrateur;
    }

    public function setAdministrateur(?Administrateur $Administrateur): self
    {
        $this->Administrateur = $Administrateur;

        return $this;
    }
    
    public function getNom(): ?string
    {  
        return  $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        
        $this->Nom = $Nom;
       
        return $this;
    }
    
    public function getUsername(): ?string
    {  
        return  $this->username;  
    }

    public function setUsername(string $username): self
    {  
    
        $this->username = $username;

        return $this;
    }

    public function getPrenom(): ?string
    {  
        return  $this->Prenom; 
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }


    
    public function setData($id,$nom,$prenom,$email,$username,$password,$roles){
        
        $this->$id= $id;
        $this->$nom= $nom;
        $this->$prenom= $prenom;
        $this->$email= $email;
        $this->$username = $username ;
        $this->$password= $password;
        $this->setRoles( $roles);
     
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


   public function serialize():String
   {              
       $serializer= $this->initializeSerializer();
       return $jsonContent = $serializer->serialize($this, 'json') ;
    }
      
    
    public function unserialize($data){
        $serializer= $this->initializeSerializer();
        return $person = $serializer->deserialize($data, AuthEntity::class, 'xml');
   }


   public function initializeSerializer(){

        $encoders=[new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];    
        $serializer = new Serializer($normalizers, $encoders  );

        return $serializer;  

   }



    public function __toString():string
    {
        return $this->getId();  
    }
}
