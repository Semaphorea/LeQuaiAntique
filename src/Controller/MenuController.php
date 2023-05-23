<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Menu;
use App\Entity\Formule;


class MenuController extends AbstractController
{  
    use HorairesTrait;  
   
    


    #[Route('/Menu', name: 'app_menu')]
    public function menu(Request $request, EntityManagerInterface $em):Response
    {   
        $routeName = $request->attributes->get('_route');
        $page=ucwords(substr($routeName,4,strlen($routeName)), "_");  
        $navitem=['Accueil','Carte','Menu','Réservation'];      
        $horaires=$this->getHoraires($em);       
    
     

        $formules= null;
        $menus= null;
      
        $menus=$em->getRepository(Menu::class)->findAll();

        
         foreach ($menus as $menu) {
          
                    //Object récupérer sous forme de string
                    $formules=$menu->getFormule();         
                    //
                    $formules=$this->getFormuleTab($formules,$em);           
                   

                return $this->render("MainTemplates/".$page.".html.twig",[
                'page' =>$page,
                'navitem' => $navitem,
                'menus'=>$menus,
                'formules'=>$formules,
                'horaires'=>$horaires       
                ]);      
        
        }
    }


    function getFormuleTab($strjson, EntityManagerInterface $em){


        $donnees= strtr(substr($strjson,4,strlen($strjson)-3),'}','');
        $form= explode(';',$donnees);
         
        $formules=[];
        foreach($form as $for){
            $temp=explode(":" , $for);
            $idformule= $temp[count($temp)-1];       
      
               $res=$em->getRepository(Formule::class)->find( $idformule);
               if($res!=null){
               array_push($formules,$res  );
             }

             
            }
     
            return $formules;
                 
     }


}
