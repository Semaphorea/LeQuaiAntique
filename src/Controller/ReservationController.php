<?php

namespace App\Controller;

use App\Entity\AuthEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\ReservationFormType;
use App\Repository\ReservationRepository;
use App\Entity\Reservation;
use App\Entity\Client;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\SubmitButton;
use Symfony\Bundle\SecurityBundle\Security;
use App\Service\CurrentConnectedUser;
use App\Tools\HorairesTrait;


class ReservationController extends AbstractController
{
  use HorairesTrait;  






  #[Route('/Réservation/', name: 'app_réservation')]

  
  public function réservation(Request $request, EntityManagerInterface $em, CurrentConnectedUser $currentUser,String $action=null ): Response
  {

    $this->denyAccessUnlessGranted('ROLE_USER'); 
    $routeName = $request->attributes->get('_route');
    $page=ucwords(substr($routeName,4,strlen($routeName)), "_");  
    $navitem=['Accueil','Carte','Menu','Réservation'];
    $reservation = new Reservation($em);
    $horaires=$this->getHoraires($em);
    $messageReservationImpossible = null;
    $nbmaxclient = $_ENV['NB_MAX_CLIENT'];

    $form =  $this->createForm(ReservationFormType::class);
    $form->handleRequest($request);
  
    
     
    //Récupération du client   
    $currentUs=$currentUser->getCurrentConnectedUser();
    if($currentUs instanceof AuthEntity){$email=$currentUs->getEmail();}
       $client=  $em->getRepository(Client::class)->findOneByEmail($email); 
       
 
    //Persistance des données du formulaire sans discrimination de bouton submit
    if ($form->isSubmitted() && $form->isValid()) {
         
       $donnees=$form->getData();
  

      $reservation->setData(
      
        $donnees->getNombre_Adultes(),
        $donnees->getNombre_Enfants(),
        $donnees->getArrivee(),
        $donnees->getHoraireMidi(),
        $donnees->getHoraireSoir(),
        $donnees->getRemarques(),
        $donnees->getIntolerancesAlimentaires(),        
        $donnees->setClient($client)  
      );

      $isEffectifWell= false;
      if($midi=$donnees->getHoraireMidi()){ $isEffectifWell = $this->verifEffectifClient($donnees->getArrivee(),$midi); }
      if($soir=$donnees->getHoraireSoir()){ $isEffectifWell=$this->verifEffectifClient($donnees->getArrivee(),$soir); }

       if($isEffectifWell){

        $em->persist($reservation);
        $em->flush();
        $this->redirectToRoute("app_confirmation");
       }    
       else{
        $messageReservationImpossible="Notre établissement a atteint sa limite d'effectif client pour le service auquel vous souhaitiez réserver.
        Nous vous prions de nous en excuser. Merci, de choisir une autre période ou de différer votre visite à une date ultérieur. 
        Le directeur de la communication du Quai Antique";
       }  

   }
    

    $r = $this->render(
      "MainTemplates/" . $page . ".html.twig",
      [
        'page' => $page,
        'navitem' => $navitem,
        'form' => $form,
        'horaires'=>$horaires,
        'messageReservationImpossible'=>$messageReservationImpossible
      ]
    );

    $r->headers->set('Access-Control-Allow-Credentials', true);

    return $r;
  }







  #[Route(path: '/confirmation', name: 'app_confirmation')]
  public function confirmation(Request $request, EntityManagerInterface $em, ReservationRepository $r): Response
  {
    $donnees =  $r->findOneByLastId();
 
    $routeName = $request->attributes->get('_route');
    $page=ucwords(substr($routeName,4,strlen($routeName)), "_");  
    $horaires=$this->getHoraires($em);
    
    return $this->render("MainTemplages/" . $page . ".html.twig", [
      "NbAdultes" => $donnees['NbAdultes'],
      "NbEnfants" => $donnees['NbEnfants'],
      "Horaires_Soir" => $donnees['Horaires_Soir'],
      "Horaires_Midi" => $donnees['Horaires_Midi'],
      "IntolérancesAlimentaires" => $donnees['IntolerancesAlimentaires'],
      "Suggestions" => $donnees['Suggestions'],
      'horaires'=>$horaires 
    ]);
  }

  /**
   * Fonction  verifEffectifClient
   * Arg DateTime $date : Date d'arrivée
   * Arg DateTime $tranchehoraireService : Tranche horaire choisie
   * Return : Boolean 
   * Remarque : il faudrait un algorithme d'optimisation de gestion des couverts
   *            
   */
  private function verifEffectifClient($date,$tranchehoraireService){
            
          
       dd($tranchehoraireService);

       $horaire=  $this->em->getRepository(Horaires::class)->findByDay() ; 
       
      
           //Récupération de l'heure de fin de service midi 
           $dejeunerend = $this->em->getRepository('Horaires')->findFindeServiceMidi();

           $nbclientsoir = $this->em->getRepository('Réservation')->findNbClientSoir($dejeunerend);
           $nbclientmidi = $this->em->getRepository('Réservation')->findNbClientMidi($dejeunerend);
     
    
  }
}
