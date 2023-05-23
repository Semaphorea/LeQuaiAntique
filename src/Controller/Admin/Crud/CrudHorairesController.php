<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Horaires;
use App\Form\HorairesType;
use App\Repository\HorairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;  
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/crud/horaires')]
class CrudHorairesController extends AbstractController
{
    #[Route('/', name: 'app_crud_horaires_index', methods: ['GET'])]
    public function index(HorairesRepository $horairesRepository): Response
    {   

        return $this->render('/AdminTemplate/Crud/crud_horaires/index.html.twig', [
            'horairesAdmin' => $horairesRepository->findAll(),
            
        ]);
    }

    #[Route('/new', name: 'app_crud_horaires_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HorairesRepository $horairesRepository): Response
    {
        $horaire = new Horaires();
        $form = $this->createForm(HorairesType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $horairesRepository->save($horaire, true);

            return $this->redirectToRoute('app_crud_horaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/crud_horaires/new.html.twig', [
            'horaire' => $horaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_horaires_show', methods: ['GET'])]
    public function show(Horaires $horaire): Response
    {
        return $this->render('/AdminTemplate/Crud/crud_horaires/show.html.twig', [
            'horaire' => $horaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crud_horaires_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Horaires $horaire, HorairesRepository $horairesRepository): Response
    {
        $form = $this->createForm(HorairesType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $horairesRepository->save($horaire, true);

            return $this->redirectToRoute('app_crud_horaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/crud_horaires/edit.html.twig', [  
            'horaire' => $horaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_horaires_delete', methods: ['POST'])]
    public function delete(Request $request, Horaires $horaire, HorairesRepository $horairesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$horaire->getId(), $request->request->get('_token'))) {
            $horairesRepository->remove($horaire, true);
        }

        return $this->redirectToRoute('app_crud_horaires_index', [], Response::HTTP_SEE_OTHER);
    }
}
