<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{


    public function __construct(...$args)
    {

        $n= 0;
        if($args == null ){$n=0;}  
         else{
            $n=count($args);
            switch($n){
                case 0 :$this->id=null;$this->titre=null;$this->binaryfile=null;break;  
                case 3 : $this->id=$args[0];$this->titre=$args[1]; $this->binaryfile=$args[2];break;        
            }


        }
    }
    #[ORM\Id]
    #[ORM\GeneratedValue] 
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 64)]
    protected ?string $titre = null;

    #[ORM\Column(type: Types::BLOB)]
    protected   $binaryfile = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
         $this->id=$id;
         return $this;
    }


    public function gettitre(): ?string
    {
        return $this->titre;
    }

    public function settitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getBinaryFile()
    {
        return $this->binaryfile;
    }

    public function setBinaryFile(  $binaryfile): self
    {
        $this->binaryfile =   $binaryfile;
        return $this;
    }

    public function __toString(){
          return $this->getId();
    }
}
