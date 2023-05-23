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

class CreditsController extends AbstractController   
{  
    use HorairesTrait;  
    public function __construct(){

     }

    #[IsGranted('ROLE_ADMIN')]  
    #[Route('/Administration/Crédits', name:'app_credits')]  
    public function credits(EntityManagerInterface $em,Request $request):Response
    {
       $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $routeName = $request->attributes->get('_route'); 
        $page=ucwords(substr($routeName,4,strlen($routeName)), "_");  
        $navitem=['Administration','Gestion Administrateur','Gestion Client','Gestion Menus','Crédits'];     
        $horaires=$this->getHoraires($em); 
        
        $item=['Gestion Administrateur','Gestion Client', 'Crédits'];

       
        return $this->render('AdminTemplate\adminCreditsTemplate.html.twig', [
          'page'=>$page,
          'navitem'=>$navitem, 
          'items'=> $item,
          'horaires'=>$horaires 
        ]);
    }

   
   
}
