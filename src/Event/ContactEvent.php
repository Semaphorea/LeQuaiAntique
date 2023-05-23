<?php

namespace App\Event ;


use Symfony\Contracts\EventDispatcher\Event;


class ContactEvent extends Event{ 

        private $nom;
        private $prenom;
        private $email;
        private $message;
        
        
        function __construct($nom, $prenom,$email,$message){
            $this->nom=$nom;
            $this->prenom=$prenom;
            $this->email=$email;
            $this->message=$message;          
        }
        
        function getNom(){return $this->nom;}
        function getPrenom(){return $this->prenom;}
        function getEmail(){return $this->email;} 
        function getMessage(){return $this->message;}
   

}
