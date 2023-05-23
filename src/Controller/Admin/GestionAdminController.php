<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Crud\CrudAdministrateurController;
use App\Controller\Admin\Crud\CrudHorairesController;
use App\Entity\AuthEntity;
use App\Entity\Horaires;
use App\Entity\Administrateur;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;

class GestionAdminController extends AbstractController   
{  
    use HorairesTrait;  
    public function __construct(){

     }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/Administration/Gestion Administrateur', name:'app_gestion_administrateur')]  
    public function gestionadmin(EntityManagerInterface $em,Request $request):Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');  
        $routeName = $request->attributes->get('_route'); 
        $page=ucwords(substr($routeName,4,strlen($routeName)), "_");     
        $navitem=['Administration','Gestion Administrateur','Gestion Client','Gestion Menus','Crédits'];    
        $horaires=$this->getHoraires($em); 

           

       
           $administrateur="";
           $administrateur = $em->getRepository(Administrateur::class)->findAll();
         //  dd($administrateur);

           // Gestion des photos Caroussel
           // $photoCrud= new CrudPhotoCaroussel(); 


          // Horaires d'ouverture  
                   
            $horairesAdmin=$em->getRepository(Horaires::class)->findAll();
            
             $nbmaxclient=0;
             $ptab=array();  
            
             try{
             $ptab=$_POST['nbmaxclient'];
        
                if(isset($ptab) &  $ptab !=null){
                    $_ENV['NB_MAX_CLIENT']=$ptab;
            }
          }catch(\Exception $e){ $e->getTraceAsString();}  


          $nbmaxclient= $_ENV['NB_MAX_CLIENT'];  

        

        return $this->render('AdminTemplate\gestionAdminTemplate.html.twig', [
            'page'=>$page,
            'navitem'=>$navitem,
            'administrateurs'=>$administrateur,
            'horairesAdmin'=>$horairesAdmin,
            'horaires'=>$horaires,
            'nbmaxclient'=>$nbmaxclient
           
            ] );
    }

   
    
}
