<?php

namespace App\Controller\Admin\Plats;

use App\Entity\Dessert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Tools\HorairesTrait;
use App\Tools\PhotoTool;

#[Route('/Administration/Gestion Menus')]
class GestionDessertController extends AbstractController
{
    use HorairesTrait;
    use PhotoTool;

    private ?EntityManagerInterface $em=null;  

    function __construct(EntityManagerInterface $em)
    {
           $this->em=$em;
    }


    #[Route('/Desserts', name: 'app_gestion_dessert')]
    public function desserts(Request $request): Response
    {

        $routeName = $request->attributes->get('_route'); 
        $page=substr($routeName,4,strlen($routeName));  
        $navitem=['Administration','Administration/Gestion Administrateur','Administration/Gestion Client','Administration/Gestion Menus','Administration/Crédits'];  
        $horaires=$this->getHoraires($this->em);

       
        $desserts=$this->fetchDonneesEntity(Dessert::class);
        if($desserts==null){$desserts=$this->em->getRepository(Dessert::class)->findAll();}
        //dd($desserts);
        return $this->render('AdminTemplate/Gestion_Menus/Desserts.html.twig', [
              'page'=>$page,
              'navitem'=>$navitem,
              'desserts'=>$desserts,
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
