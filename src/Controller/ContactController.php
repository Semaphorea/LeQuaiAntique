<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;
use App\Tools\HorairesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Event\ContactEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ContactController extends AbstractController
{
    use HorairesTrait;

    #[Route('/Contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $em, EventDispatcherInterface $dis): Response
    {
        $routeName = $request->attributes->get('_route');
        $page = ucwords(substr($routeName, 4, strlen($routeName)), "_");
        $navitem = ['Accueil', 'Carte', 'Menu', 'Réservation'];
        $horaires = $this->getHoraires($em);

        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        $contact = new Contact();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $nom = $data->getNom();
            $prenom = $data->getPrenom();
            $mail = $data->getEmail();
            $message = $data->getMessage();

            $contact->setNom($nom);
            $contact->setPrenom($prenom);
            $contact->setEmail($mail);
            $contact->setMessage($message);


            $em->persist($contact);
            $em->flush();

            $event = new ContactEvent($nom, $prenom, $mail, $message);

            $dis->dispatch($event);
        }

        return $this->render('MainTemplates/contact.html.twig', [
            'page' => $page,
            'navitem' => $navitem, 'contact' => $form,
            'horaires' => $horaires
        ]);
    }
}
