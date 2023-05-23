<?php

namespace App\Controller\Admin\Crud\Plats;

use App\Entity\Boisson;
use App\Form\BoissonType;
use App\Repository\BoissonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;
use App\Entity\Photo;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Tools\PhotoTool;

#[Route('/crud/boisson')]
class CrudBoissonController extends AbstractController
{
    use PhotoTool;

    private ?FileUploader $fileUploader = null;
    private ?SluggerInterface $sluger = null;
    private ?EntityManagerInterface $em = null;


    function __construct(FileUploader $fileUploader = null, SluggerInterface $sluger = null, EntityManagerInterface $em)
    {
        $this->fileUploader = $fileUploader;
        $this->sluger = $sluger;
        $this->em = $em;
    }



    #[Route('/', name: 'app_crud_boisson_index', methods: ['GET'])]
    public function index(): Response
    {

        $boissons = $this->fetchDonneesEntity(Boisson::class);


        return $this->render('/AdminTemplate/Crud/Plats/crud_boisson/index.html.twig', [
            'boissons' => $boissons
        ]);
    }

    #[Route('/new', name: 'app_crud_boisson_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  BoissonRepository $boissonRepository): Response
    {
        $boisson = new Boisson();
        $form = $this->createForm(BoissonType::class, $boisson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->photoCreate($form, $boisson); 

            $boissonRepository->save($boisson, true);

            return $this->redirectToRoute('app_crud_boisson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/Plats/crud_boisson/new.html.twig', [
            'boisson' => $boisson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_boisson_show', methods: ['GET'])]
    public function show($id,Boisson $boisson): Response
    {

        $boisson = $this->fetchDonneesEntity(Boisson::class, $id)[0];
        return $this->render('/AdminTemplate/Crud/Plats/crud_boisson/show.html.twig', [
            'boisson' => $boisson,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crud_boisson_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Boisson $boisson, BoissonRepository $boissonRepository): Response
    {
        $form = $this->createForm(BoissonType::class, $boisson);
        $form->handleRequest($request);
      
     

        if ($form->isSubmitted() && $form->isValid()) {

            $this->photoCreate($form, $boisson);
            //     dd($boisson);  

            $boissonRepository->save($boisson, true);

            return $this->redirectToRoute('app_crud_boisson_index', ['boisson' => $boisson], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/Plats/crud_boisson/edit.html.twig', [
            'boisson' => $boisson,
           
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_boisson_delete', methods: ['POST'])]
    public function delete(Request $request, Boisson $boisson, BoissonRepository $boissonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $boisson->getId(), $request->request->get('_token'))) {
            $boissonRepository->remove($boisson, true);
        }

        return $this->redirectToRoute('app_crud_boisson_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Function photoCreate
     * Args FileUploader
     * Args Form
     * Args Entité
     * Return Void  
     */
    function photoCreate($form, $entity)
    {


        $photoFilePath = $form->offsetGet('Photo')->getData()->getPath();  //Je trouve la photo lorsque je recherche les éléments enfants
        $photoFile = $form->offsetGet('Photo')->getData();



        if (isset($photoFile)) {
            $uploadedphoto = $this->fileUploader->upload($photoFile);
        }

        $file = file_get_contents($this->fileUploader->getPhotoNewPath() . DIRECTORY_SEPARATOR . $uploadedphoto, false);
        $photoEntity = new Photo(null, $uploadedphoto, $file);

        $doublons = $this->searchDoublonPhoto($uploadedphoto);

        if (!$doublons) {

            $photorep = $this->em->getRepository(Photo::class);
            $photorep->save($photoEntity, true);
            $photoid = $photorep->findIdByTitreDQL($uploadedphoto);

            $photoEntity->setId($photoid['id']);

            $entity->setPhoto($photoEntity);
            // dd($entity);
        } else {
            echo "<p class='bs-danger'> Notre base de donnée contient déjà votre photo, ou nous n'avons pas été en mesure d'intégrer celle-ci à notre base de donnée. Merci de réitérer votre envoie ou contacter le service technique si le problème persiste ! </p>";
        }
    }


    function searchDoublonPhoto($titre)
    {
        try {
            $photoid = $this->em->getRepository(Photo::class)->findIdByTitreDQL($titre);
            if ($photoid[0] != null) {
                return true;
            }
        } catch (\Exception $e) {
            echo "<p class='bs-danger'>cf. CrudBoissonController L168 : La recherche de doublons dans la table Photo n'a pas abouti : " . $e->getTraceAsString() . " </p>";
        };
        return false;
    }

    /**
     * Function fetchDonneesPhoto
     * Return   tabentites[tabentite[dataview [set[binary,titre] ]]]
     */
    function fetchDonneesEntity($entity, $id=null, EntityManagerInterface $em = null): array
    { 
        if ($id != null) {
           $entites[0]= $this->em->getRepository($entity)->findByIdDQL($entity,$id);
        } else {
            $entites = $this->em->getRepository($entity)->findAllDQL($entity);
        }

       
        $i = 0;
        foreach ($entites as $entite) {
            $entites[$i]['dataview'] = ['set' => $this->displayFile($entite['binaryfile'], $entite['titre'])];
            $i++;
        }
        return $entites;
    }
}
