<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;




class AccesController extends AbstractController
{
    use HorairesTrait;

    #[Route('/Accès', name: 'app_accès')]
    public function acces(EntityManagerInterface $em, Request $request): Response
    {
        $routeName = $request->attributes->get('_route');
        $page = ucwords(substr($routeName, 4, strlen($routeName)), "_");
        $navitem = ['Accueil', 'Carte', 'Menu', 'Réservation'];
        $horaires = $this->getHoraires($em);

        return $this->render("MainTemplates/" . $page . ".html.twig", [
            'page' => $page,
            'navitem' => $navitem,
            'horaires' => $horaires
        ]);
    }
}
