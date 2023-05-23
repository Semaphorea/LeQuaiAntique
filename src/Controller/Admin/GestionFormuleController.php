<?php


namespace App\Controller\Admin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Formule;    

class GestionFormuleController extends AbstractController
{

    use HorairesTrait;   
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/Administration/Gestion Menus/Formules', name: 'app_gestion_formules')]
    public function formule(EntityManagerInterface $em,Request $request): Response
    {
        $routeName = $request->attributes->get('_route');
        $page=ucwords(substr($routeName,4,strlen($routeName)), "_");  
        $navitem=['Administration','Administration/Gestion Administrateur','Administration/Gestion Client','Administration/Gestion Menus','Administration/Crédits'];   
        //dd($page);
  
        $horaires=$this->getHoraires($em);       
             

              

        return $this->render("/AdminTemplate/Gestion_Menus/gestionFormuleTemplate.html.twig",['page' =>$page,
         'navitem' => $navitem,
         'formules'=>   $em->getRepository(Formule::class)->findAll()  ,
         'horaires'=>$horaires   
    
     ]);      
    }
}
