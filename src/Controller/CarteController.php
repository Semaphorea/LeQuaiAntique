<?php

namespace App\Controller;

use App\Entity\PlatPrincipal;
use App\Entity\Entree;
use App\Entity\Dessert;
use App\Entity\Boisson;
use App\Repository\DessertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;

class CarteController extends AbstractController
{
    use HorairesTrait;


    #[Route('/Carte', name: 'app_carte')]
    public function carte(Request $request, EntityManagerInterface $em, DessertRepository $dessertr): Response
    {
        $routeName = $request->attributes->get('_route');
        $page = ucwords(substr($routeName, 4, strlen($routeName)), "_");
        $navitem = ['Accueil', 'Carte', 'Menu', 'Réservation'];
        $horaires = $this->getHoraires($em);

        $entrees = $em->getRepository(Entree::class)->findAll();

        $plats = $em->getRepository(PlatPrincipal::class)->findAll();

        $desserts = $em->getRepository(Dessert::class)->findAll();

        $boissons = $em->getRepository(Boisson::class)->findAll();



        return $this->render(
            "MainTemplates/" . $page . ".html.twig",
            [
                'page' => $page, 'navitem' => $navitem,
                'entrees' => $entrees,
                'plats' => $plats,
                'desserts' => $desserts,
                'boissons' => $boissons,  
                'horaires' => $horaires
            ]
        );
    }
}
