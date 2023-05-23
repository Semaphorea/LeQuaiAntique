<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Photo;
use App\Tools\PhotoTool;



class AccueilController extends AbstractController
{
    use HorairesTrait;
    use PhotoTool;
 
    #[Route(path: '/Accueil', name: 'app_accueil')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $routeName = $request->attributes->get('_route');
        $page = ucwords(substr($routeName, 4, strlen($routeName)), "_");
        $navitem = ['Accueil', 'Carte', 'Menu', 'Réservation'];

        $horaires = $this->getHoraires($em);
        $photoList = null;
        $photoList = $em->getRepository(Photo::class)->findAll();
  


        $binaryFileList = [];
        foreach ($photoList as $p) {
          // dd($p->getBinaryFile()); 
          
          
          //  $photo=file($p->getTitre(),FILE_USE_INCLUDE_PATH,$p->getBinaryFile());
          //  $photo=file($p->getBinaryFile());
           // $photocentered=$this->photocenterfromstr(stream_get_contents($p->getBinaryFile(),-1),$p->getTitre(),'250','250');
            
            // $phototab = $this->displayPhoto2($photocentered,$p);
               $phototab = $this->displayPhoto($p);
            array_push($binaryFileList, $phototab);
        }


        return $this->render("MainTemplates/" . $page . ".html.twig", [
            'page' => $page,
            'navitem' => $navitem,
            'photoBinary' => $binaryFileList,
            'horaires' => $horaires


        ]);
    }

    #[Route(path: '/accueil', name: 'app_accueil_bis')]
    public function index2(): Response
    {
        return $this->redirectToRoute('app_accueil');
    }
}
