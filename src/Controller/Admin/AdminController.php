<?php

namespace App\Controller\Admin;

use App\Entity\AuthEntity;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;


#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController   
{  
  use HorairesTrait;  

    public function __construct( ) {  }

    
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/Admin', name: 'app_Admin')]   
    public function index(): Response
     {    
    
           $user = $this->getUser();
           if($user instanceof AuthEntity) $role=$user->getRoles()[0];  
         
             if ($role === "ROLE_ADMIN") { 
             return $this->redirect('Administration');
           }  
  
        return $this->redirect('Accueil');;
    }


    
  
     

    #[IsGranted('ROLE_ADMIN')]  
    #[Route('/Administration', name:'app_administration')]
    public function admin(EntityManagerInterface $em,Request $request):Response
    {  
      //  $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $routeName = $request->attributes->get('_route'); 
        $page=ucwords(substr($routeName,4,strlen($routeName)), "_");   
        $navitem=['Administration','/Administration/Gestion Administrateur','/Administration/Gestion Client','/Administration/Gestion Menus','/Administration/Crédits'];      
        $item=['/Administration/Gestion Administrateur','/Administration/Gestion Client', '/Administration/Gestion Menus','/Administration/Crédits'];
        $horaires=$this->getHoraires($em); 
              
        return $this->render('AdminTemplate\adminTemplate.html.twig', 
         [
            'page'=>$page, 
            'navitem'=>$navitem,
            'items'=> $item,
            'horaires'=>$horaires
              
        ]);
    }

   
}
