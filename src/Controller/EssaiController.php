<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Menu;
use App\Entity\Formule;
use App\Entity\Entree;
use App\Entity\PlatPrincipal;
use App\Entity\Dessert;
use Doctrine\ORM\EntityManagerInterface;
 
//Controller permettant d'entrer des données Menu et Formule en BDD
//L'insertion en CLI ne donnant pas les résultats escomptés. 
class EssaiController extends AbstractController
{
    #[Route('/essai', name: 'app_essai')]
    public function index(EntityManagerInterface $em): Response
    { 
     

        $res=\Doctrine\DBAL\Types\Type::getTypesMap();
        // $f=new Formule();
        // $f->setTitre('dîner');
        // $f->setPlats([new Entree(),new PlatPrincipal(), new Dessert()]);
        // $f->setPrix('80');       
        // $f->setDateApplication(new   \DateTime());
        // $f->setDescription('entree + plat + dessert');
       
       
       
        // $m= new Menu();
        // $m->setTitre('Menu Savoyard');
        // $m->setFormule($f);

        // $f->setMenu($m);
        
        // $em->persist($f);
        // $em->persist($m);
        // $em->flush();
        



 dd($res);


        return $this->render('essai/index.html.twig', [
           'res'=>$res
        ]);
    }
}
