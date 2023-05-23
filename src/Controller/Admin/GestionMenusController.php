<?php

namespace App\Controller\Admin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Menu;  

#[IsGranted('ROLE_ADMIN')]
class GestionMenusController extends AbstractController
{
    use HorairesTrait;   
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/Administration/Gestion Menus', name: 'app_gestion_menus')]
    public function gestionAdminMenu(EntityManagerInterface $em,Request $request): Response
    {
        $routeName = $request->attributes->get('_route'); 
        $page=ucwords(substr($routeName,4,strlen($routeName)), "_");   
        $navitem=['Administration','Gestion Administrateur','Gestion Client','Gestion Menus','Crédits'];    
        $horaires=$this->getHoraires($em); 

        $item1=['entrées','plats','desserts','boissons'];           


        $menu=null;    
        $formules=null;
     
 

        return $this->render('/AdminTemplate/Gestion_Menus/gestionMenuTemplate.html.twig', [ 
            'page'=>$page,
            'navitem'=>$navitem,
            'horaires'=>$horaires,  
            'item1'=>['formules'], 
            'item2'=>['menus'], 
            'item3'=> $item1,
            'formules'=>$formules,
            'menus'=> $menu,
          
        ]);
    }


    #[Route('/Administration/Gestion Menus/Menus', name: 'app_gestion_menus_formules')]
    public function gestionMenu(EntityManagerInterface $em,Request $request): Response
    {
        $routeName = $request->attributes->get('_route'); 
        $page=ucwords(substr($routeName,4,strlen($routeName)), "_");   
        $navitem=['Administration','Gestion Administrateur','Gestion Client','Gestion Menus','Crédits'];    
        $horaires=$this->getHoraires($em); 

       $menu= $em->getRepository(Menu::class)->findAll();

        return $this->render('/AdminTemplate/Gestion_Menus/gestionMenuFTemplate.html.twig',[
            'menus'=>$menu,
            'page'=>$page,
            'navitem'=>$navitem,
            'horaires'=>$horaires,
        ]);

    }
}
