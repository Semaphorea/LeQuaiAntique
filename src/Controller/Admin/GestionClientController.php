<?php

namespace App\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route; 
use App\Controller\Admin\Crud\CrudClientController; 
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Client;


class GestionClientController extends AbstractController   
{  
    use HorairesTrait;  
   
    public function __construct(){    
         
     }  

     #[IsGranted('ROLE_ADMIN')]
    #[Route('/Administration/Gestion Client', name:'app_gestion_client')]  
    public function gestionclient(EntityManagerInterface $em,Request $request):Response
    {  
      //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $routeName = $request->attributes->get('_route'); 
        $page=ucwords(substr($routeName,4,strlen($routeName)), "_");  
        $navitem=['Administration','Gestion Administrateur','Gestion Client','Gestion Menus','Crédits'];    
        $horaires=$this->getHoraires($em); 

        //Crud Client
      
           $crud= new CrudClientController();
        
      
      
        return $this->render('AdminTemplate/gestionClientTemplate.html.twig',[
            'clients' => $em->getRepository(Client::class)->findAll(),        
            'page'=>$page,  
            'navitem'=>$navitem,
            'horaires'=>$horaires
            
        ]); 
       
    }
    

}  
