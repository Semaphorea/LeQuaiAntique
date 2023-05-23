<?php


namespace App\Entity\Model;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;


// \Serializable interface pouvant être ajoutée  
abstract class Personne implements UserInterface{
 
    function __construct(...$args){
        if ($args==null){$n=0;}
        else{$n= count($args);}
        switch($n){
            case 0 :  
                        $this->id=null;      //$id;
                        $this->Nom=null;     //$Nom;
                        $this->Prenom=null;  //$Prenom;
                        $this->username=null;//$username=$email;
                        $this->email=null;   //$email;
                        break; 
            case 4 : 
                        $this->id=$args[0];      //$id;
                        $this->Nom=$args[1];     //$Nom;
                        $this->Prenom=$args[2];  //$Prenom;
                        $this->username=$args[3];//$username=$email;
                        $this->email=$args[3];   //$email;
                        break; 
            case 5:    
                        $this->id=$args[0];       //$id;
                        $this->Nom=$args[1];      //$Nom;
                        $this->Prenom=$args[2];   //$Prenom;
                        $this->username=$args[3]; //$username=$email;
                        $this->email=$args[3];    //$email;
                        $this->password=$args[4]; //password
                        break;       
        }
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id;

    #[ORM\Column(length: 64)]
    protected ?string $username;

    #[ORM\Column(length: 256)]
    protected ?string $password;
 
   
    #[ORM\Column(length: 64)]
    protected ?string $Nom;

    #[ORM\Column(length: 64)]  
    protected ?string $Prenom;

    #[ORM\Column(length: 128)]
    public ?string $email;   //A l'origine en protected : Obligé de mettre en public sinon impossible de flusher les données dans CrudClientController


   
  
 
    public function getUsername()
    {
        return $this->username;  
    }
 
  

    public function getPassword()
    {  
        return $this->password;
    }

    public function getUserIdentifier(): string{
        return $this->id;
    }

    abstract public function getRoles():Array;
   
   
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }


    public function eraseCredentials()
    {
    }
    
    /** Existe dans la définition de de User, mais en a-t-on vraiment besoin ?
    // /** @see \Serializable::serialize() */
    // public function serialize()
    // {
    //     return serialize(array(
    //         $this->id,
    //         $this->username,
    //         $this->password,
    //         // see section on salt below
    //         // $this->salt,
    //     ));
    // }

    // /** @see \Serializable::unserialize() */
    // public function unserialize($serialized)
    // {
    //     list (
    //         $this->id,
    //         $this->username,
    //         $this->password,
    //         // see section on salt below
    //         // $this->salt
    //     ) = unserialize($serialized, array('allowed_classes' => false));
    // }

    
     
 }
 
