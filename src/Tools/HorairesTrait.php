<?php

namespace App\Tools;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Horaires;

trait HorairesTrait{
      
     /**
      * Function getHoraires()
      * Arg EntityManagerInterface
      * Return : String[Midi[ServiceDeb[horaire,date],ServiceFin[horaire,date]], Soir[ServiceDeb[horaire,date],ServiceFin[horaire,date]]]
      */ 
     public function getHoraires(EntityManagerInterface $em){

             $horaireR = $em->getRepository(Horaires::class);
             $horaire= $horaireR->findActive();  
         

             $dateform = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::NONE, \IntlDateFormatter::NONE);
             $dateform ->setPattern('k:mm'); 
             
             $dateform2 = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::NONE, \IntlDateFormatter::NONE);
             $dateform2 ->setPattern('EEEE MM YYYY');

             $strhorairetab=null;

           
             $strhorairetab= [                                                                              
                  [$dateform ->format( $horaire->getDejeunerDebut()),$dateform2 ->format( $horaire->getDejeunerDebut())],
                  [$dateform ->format( $horaire->getDejeunerFin()), $dateform2 ->format( $horaire->getDejeunerFin())],
                  [$dateform ->format( $horaire->getDinerDebut()),$dateform2 ->format( $horaire->getDinerDebut())],
                  [$dateform ->format( $horaire->getDinerFin()),$dateform2 ->format( $horaire->getDinerFin())],               
               ];
               
                 
            

            return $strhorairetab;

     }



}




