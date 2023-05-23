<?php

namespace App\Controller\Admin\Plats;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Tools\HorairesTrait;
use App\Entity\PlatPrincipal;
use App\Tools\PhotoTool;

#[Route('/Administration/Gestion Menus')]
class GestionPlatController extends AbstractController
{
    use HorairesTrait;
    use PhotoTool;

    private ?EntityManagerInterface $em=null;  

    function __construct(EntityManagerInterface $em)
    {
           $this->em=$em;
    }

    #[Route('/Plats', name: 'app_gestion_plats')]
    public function plat(Request $request): Response
    {

        $routeName = $request->attributes->get('_route'); 
        $page=substr($routeName,4,strlen($routeName));  
        $navitem=['Administration','Administration/Gestion Administrateur','Administration/Gestion Client','Administration/Gestion Menus','Administration/Crédits'];  
        $horaires=$this->getHoraires($this->em);
        $plats=$this->fetchDonneesEntity(PlatPrincipal::class);
        if($plats==null){$plats=$this->em->getRepository(PlatPrincipal::class)->findAll();}
          
        return $this->render('AdminTemplate/Gestion_Menus/Plats.html.twig', [
            'page'=>$page,
            'navitem'=>$navitem,
            'plat_principaux'=> $plats,
            'horaires'=>$horaires
        ]);
    }
    /**
     * Function fetchDonneesPhoto
     * Return   tabentites[tabentite[dataview [set[binary,titre] ]]]
     */
    function fetchDonneesEntity($entity,$id=null, EntityManagerInterface $em= null ):array{
       
        if ($id != null) {
            $this->em->getRepository($entity)->findByIdDQL($entity);
        } else {
            $entites = $this->em->getRepository($entity)->findAllDQL($entity);
        }
        $i=0;
        foreach($entites as $entite){        
                 $entites[$i]['dataview']= ['set'=> $this->displayFile( $entite['binaryfile'],$entite['titre'])];
                 $i++;        
            } 
      return $entites;
    }
}
