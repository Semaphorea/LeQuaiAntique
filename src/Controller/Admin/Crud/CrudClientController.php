<?php

namespace App\Controller\Admin\Crud;

use App\Entity\AuthEntity;
use App\Entity\Client; 
use App\Form\ClientType;
use App\Repository\AuthEntityRepository;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;  
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/crud/client')] 
class CrudClientController extends AbstractController
{   
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_crud_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('/AdminTemplate/Crud/crud_client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_crud_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientRepository $clientRepository, AuthEntityRepository $authEntityRepository): Response
    {
        $client = new Client();
        
        
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donnees=$form->getData();  //Password confirmation n'est pas récupéré.
            
         
                     

        
            $auth_entity= new AuthEntity(null,
                                        $donnees->Nom,
                                        $donnees->Prenom,
                                        $donnees->email,
                                        $donnees->getAuthEntity()->getPassword(),
                                        $donnees->getAuthEntity()->getPasswordConfirmation(),
                                        
            );
         
            $auth_entity->setRoles(['ROLE_USER']); 
            
            $authEntityRepository->save($auth_entity,true);
            $authent=$authEntityRepository->findOneByEmailDQL($donnees->email);
            $client->setAuthEntity($authent); 
           // dd($authent);
            

           // $client->getAuthEntity()->setPassword($donnees->getAuthEntity()->getPassword());
           // $client->getAuthEntity()->setPasswordConfirmation($donnees->getAuthEntity()->getPasswordConfirmation());
            $client->setDateTimeCreation(null);
            $client->setDatas($donnees->Nom, $donnees->Prenom, $donnees->email,$donnees->nbConvive,$donnees->IntolerancesAlimentaires);
            $client->setCommande('');
            $client->setReservation('');
            $client->setUsername($donnees->getEmail());
            
            $client->setPassword($donnees->getPassword());
            $clientRepository->save($client, true);


            return $this->redirectToRoute('app_crud_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/crud_client/new.html.twig', [ 
            'client' => $client,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_crud_client_show', methods: ['GET'])]
    public function show(Client $client): Response
    {
        return $this->render('/AdminTemplate/Crud/crud_client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_crud_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $form = $this->createForm(ClientType::class, $client);

        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->save($client, true);

            return $this->redirectToRoute('app_crud_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/crud_client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_crud_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $clientRepository->remove($client, true);
        }

        return $this->redirectToRoute('app_crud_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
