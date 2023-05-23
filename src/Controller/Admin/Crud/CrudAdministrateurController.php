<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Administrateur;
use App\Entity\AuthEntity;
use App\Form\AdministrateurType;
use App\Repository\AdministrateurRepository;
use App\Repository\AuthEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/crud/administrateur')]
class CrudAdministrateurController extends AbstractController
{
    #[Route('/', name: 'app_crud_administrateur_index', methods: ['GET'])]
    public function index(AdministrateurRepository $administrateurRepository): Response
    {

        $a=$administrateurRepository->findAll();
     
        return $this->render('/AdminTemplate/Crud/crud_administrateur/index.html.twig', [
            'administrateurs' =>$a ,
        ]);  
    }


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_crud_administrateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AuthEntityRepository $authEntityRepository,EntityManagerInterface $em): Response
    {

      
        $administrateur = new Administrateur();
        $auth_entity=new AuthEntity();
        $administrateur->setAuthEntity($auth_entity);  
 
        $form = $this->createForm(AdministrateurType::class, $administrateur);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           

            $donnees= $form->getData();

                $authentity=$administrateur->getAuthEntity();
                $authentity->setUsername($donnees->getEmail());
                $authentity->setNom( $donnees->getNom());
                $authentity->setPrenom( $donnees->getPrenom());
                $authentity->setEmail($donnees->getEmail());
      
            $authentity->setPassword($donnees->getPassword());
            $authentity->setPasswordConfirmation($donnees->getPassword()); 
            $authentity->setRoles(['ROLE_ADMIN']);
            $authEntityRepository->save($authentity,true);
            $authent=$em->getRepository(AuthEntity::class)->findOneByEmailDQL($donnees->getEmail());           
         
            $administrateur->setUsername($donnees->getEmail());
            $administrateur->setPassword($donnees->getPassword());
            $administrateur->setNom($donnees->getNom());
            $administrateur->setPrenom($donnees->getPrenom()); 
            $administrateur->setAuthEntity($authent);
     
           $em->persist($administrateur);
            $em->flush();
            return $this->redirectToRoute('app_crud_administrateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/crud_administrateur/new.html.twig', [   
            'administrateur' => $administrateur,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_crud_administrateur_show', methods: ['GET'])]
    public function show(Administrateur $administrateur): Response
    {
        return $this->render('/AdminTemplate/Crud/crud_administrateur/show.html.twig', [
            'administrateur' => $administrateur,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_crud_administrateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Administrateur $administrateur, AdministrateurRepository $administrateurRepository): Response
    {
        $form = $this->createForm(AdministrateurType::class, $administrateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $administrateurRepository->save($administrateur, true);

            return $this->redirectToRoute('app_crud_administrateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/crud_administrateur/edit.html.twig', [
            'administrateur' => $administrateur,  
            'form' => $form,  
        ]);
    }

    
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_crud_administrateur_delete', methods: ['POST'])]
    public function delete(Request $request, Administrateur $administrateur, AdministrateurRepository $administrateurRepository, AuthEntityRepository $authEntityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$administrateur->getId(), $request->request->get('_token'))) {
            
            $entity=$authEntityRepository->findOneByEmailDQL($administrateur->getEmail()); 

            $authEntityRepository->remove($entity, true);
            $administrateurRepository->remove($administrateur, true);
        }

        return $this->redirectToRoute('app_crud_administrateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
