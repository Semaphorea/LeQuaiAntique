<?php

namespace App\Entity;

use App\Entity\Model\Plat;
use App\Entity\Menu;
use App\Repository\FormuleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;  
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use App\Tools\Trace;
#[ORM\Entity(repositoryClass: FormuleRepository::class)]
class Formule
{

   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]  
    private ?string $Titre = null;  

    #[ORM\Column(length: 128)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::ARRAY)]
    private Mixed $Plats = [];

    #[ORM\Column]
    private ?float $Prix = null;
   
    #[ORM\Column]   
    #[ORM\ManyToOne(targetEntity:Menu::class, inversedBy:'Formule')]  
    #[ORM\JoinColumn(name:'menu_id',referencedColumnName:'id')]
    private  Mixed $Menu = null; 

    #[ORM\Column(length: 128)]
    private Mixed $DateApplication = null;   

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPlats(): Mixed
    {
        return $this->Plats;
    }

    public function setPlats(Mixed $Plats): self
    {
        $this->Plats = $Plats;

        return $this;
    }

    public function getPrix(): ?float
    {
     
        return $this->Prix;
        
    }
    /**
     * setPrix
     * $arg Plat|String|Float  
     */
    public function setPrix(Mixed $arg ): self
    {
       
        if(is_float($arg)){$this->Prix=$arg;}
        else if ( is_array($arg & $arg[0] instanceof Plat)){
            foreach ($arg as $plat) {
                $this->Prix += $plat->getPrix;
            }
        }
        else if(is_string($arg)){$this->Prix =  (float)trim($arg);}  //Or floatval()
  

        return $this;
    } 


    public function getMenu()
    {
        return $this->Menu;
    }

    public function setMenu(Mixed $Menu): self
    {
        $this->Menu = $Menu;

        return $this;
    }


    public function getDateApplication()
    {
        return $this->DateApplication;
    }

    public function setDateApplication(Mixed $DateApplication): self
    {
       
        $trace=Trace::init();
        $crudtrace=$trace->getTrace()[11];
        $crudtracetab=explode(DIRECTORY_SEPARATOR,$crudtrace['class']);
        
        $classOrigine=$crudtracetab[count($crudtracetab)-1];
       
        // Je dois obtenir une string, nécessaire pour l'enregistrement en base de donnée..
        // Je sais que ce n'est pas conventionnel. Je reviendrai dès que possible sur problème.
        // L'utilisation d'un DATETIME dès le départ en tant que Type mysql aurait sans doute évité cela.

        if($crudtrace['function'] == 'new' & $classOrigine=="CrudFormuleController") {
            
             
           
            $this->$DateApplication= $DateApplication;  return $this;}
        
        if(is_string($DateApplication)){
                  $DateApplication= str_replace("/","-",$DateApplication);
            
        $this->DateApplication = new \DateTime($DateApplication);
    }
    else if($DateApplication instanceof \DateTimeInterface){
            $this->DateApplication = $DateApplication;

        }
        return $this;
    }
    

    

   public function serialize():String
   {              
       $serializer= $this->initializeSerializer();
       return $jsonContent = $serializer->serialize($this, 'json') ;
    }
      
    
    public function unserialize($data){
        $serializer= $this->initializeSerializer();
        return $serializer->deserialize($data, Formule::class, 'xml');
   }


   public function initializeSerializer(){

        $encoders=[new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];    
        $serializer = new Serializer($normalizers, $encoders  );

        return $serializer;  

   }



    public function __toString()
    {
        return 'Formule : '.$this->getTitre(); 
    }
}
