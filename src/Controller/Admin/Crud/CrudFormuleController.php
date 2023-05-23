<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Formule;
use App\Form\FormuleType;
use App\Repository\FormuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/crud/formule')]
class CrudFormuleController extends AbstractController
{
    #[Route('/', name: 'app_crud_formule_index', methods: ['GET'])]
    public function index(FormuleRepository $formuleRepository,Request $request): Response
    {
        $routeName = $request->attributes->get('_route');  
        $page=ucwords(substr($routeName,4,strlen($routeName)), "_");  
        
        return $this->render('/AdminTemplate/Crud/crud_formule/index.html.twig', [
            'formules' => $formuleRepository->findAll(),
            'page'=>$page  
        ]);
    }

    #[Route('/new', name: 'app_crud_formule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormuleRepository $formuleRepository): Response
    {
      
        $formule = new Formule();
        $form = $this->createForm(FormuleType::class, $formule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
   
            $formuleRepository->save($formule, true);

            return $this->redirectToRoute('app_crud_formule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/crud_formule/new.html.twig', [
            'formule' => $formule,
            'form' => $form,
       
        ]);
    }

    #[Route('/{id}', name: 'app_crud_formule_show', methods: ['GET'])]
    public function show(Formule $formule): Response
    {
        return $this->render('/AdminTemplate/Crud/crud_formule/show.html.twig', [
            'formule' => $formule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crud_formule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formule $formule, FormuleRepository $formuleRepository): Response
    {
        $form = $this->createForm(FormuleType::class, $formule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formuleRepository->save($formule, true);

            return $this->redirectToRoute('app_crud_formule_index', [], Response::HTTP_SEE_OTHER);
        } 

        return $this->renderForm('/AdminTemplate/Crud/crud_formule/edit.html.twig', [
            'formule' => $formule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_formule_delete', methods: ['POST'])]
    public function delete(Request $request, Formule $formule, FormuleRepository $formuleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formule->getId(), $request->request->get('_token'))) {
            $formuleRepository->remove($formule, true);
        }

        return $this->redirectToRoute('app_crud_formule_index', [], Response::HTTP_SEE_OTHER);
    }
}
