<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Entity\AuthEntity;
use App\Form\NouveauClientFormType;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class ClientController extends AbstractController
{
    use HorairesTrait;
    private $em;
    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    #[Route('/nouveauclient', name: 'app_nouveauclient')]
    public function nouveauclient(Request $request, EntityManagerInterface $em): Response
    {


        $routeName = $request->attributes->get('_route');
        $page = ucwords(substr($routeName, 4, strlen($routeName)), "_");
        $navitem = ['Accueil', 'Carte', 'Menu', 'Réservation'];
        $horaires = $this->getHoraires($em);


        $messageconfirmation = "";
        $rappeldonnees = "";

        //Création des Entités
        $client = new Client();
        $authEntity = new AuthEntity();


        $client->setAuthEntity($authEntity);

        $form = $this->createForm(NouveauClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $donnees = $form->getData();

            $client->setNom($donnees->getNom());
            $client->setPrenom($donnees->getPrenom());
            $client->setEmail($donnees->getEmail());

            $authEntity->setNom($donnees->getNom());
            $authEntity->setPrenom($donnees->getPrenom());
            $authEntity->setEmail($donnees->getEmail());
            $authEntity->setPassword($donnees->getPassword());

            $authEntity->setPasswordConfirmation($donnees->getPasswordConfirmation());

            if ($authEntity->getPassword() !== $authEntity->getPasswordConfirmation()) {
                throw new CustomUserMessageAuthenticationException('Votre mot de passe ne peut pas être confirmé ! Merci de vérifier la correspondance entre mot de passe et confirmation de mot de passe.');
            }


            $client->setAuthEntity($authEntity);
            $client->setNbConvive($donnees->getNbConvive());
            $client->setIntolerancesAlimentaires($donnees->getIntolerancesAlimentaires());

            $isDoublon = $this->verifDoublons($donnees->getEmail());




            if ($isDoublon) {
                throw new CustomUserMessageAuthenticationException('Votre email est déjà présent dans notre base de donnée si vous avez oublié votre mot de passe, merci de le réinitialiser.');
            } else {

                $em->persist($authEntity);
                $em->persist($client);
                $em->flush;

                $messageconfirmation = 'Votre compte a bien été créé !';
                $rappeldonnees =  'Vous disposez entièrement de vos données et pouvez à tout moment demander le retrait de celles-ci  ainsi que la suppression de votre compte sur simple demande écrite.';
                $this->redirectToRoute('app_confirmation_client');
            }
        }




        return $this->render('MainTemplates/nouveauclient.html.twig', [
            'form' => $form,
            'page' => $page,
            'navitem' => $navitem,
            'messageconfirmation' => $messageconfirmation,
            'rappeldonnees' => $rappeldonnees,
            'horaires' => $horaires
        ]);
    }



    function verifDoublons(string $email)
    {
        $user = $this->em->getRepository(Client::class)->findOneByEmail($email);
        if ($user != null) {
            return true;
        } else {
            return false;
        }
    }
}
