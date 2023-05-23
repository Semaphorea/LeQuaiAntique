<?php

namespace App\Controller\Admin\Crud\Plats;

use App\Entity\Dessert;
use App\Form\DessertType;
use App\Repository\DessertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;
use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use App\Tools\PhotoTool;


#[Route('/crud/dessert')]
class CrudDessertController extends AbstractController
{
    use PhotoTool;

    private ?EntityManagerInterface $em=null;  

    private ?FileUploader $fileUploader=null;
    function __construct(FileUploader $fileUploader=null,EntityManagerInterface $em)
    {
      $this->fileUploader=$fileUploader;
      $this->em=$em;
    }


    #[Route('/', name: 'app_crud_dessert_index', methods: ['GET'])]
    public function index(DessertRepository $dessertRepository): Response 
    {

        ;
        return $this->render('/AdminTemplate/Crud/Plats/crud_dessert/index.html.twig', [
            'desserts' =>$this->fetchDonneesEntity(Dessert::class)
        ]);
    }

    #[Route('/new', name: 'app_crud_dessert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FileUploader $fileUploader,DessertRepository $dessertRepository): Response
    {
        $dessert = new Dessert();
        $form = $this->createForm(DessertType::class, $dessert);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->photoCreate($form,$dessert);
            $dessertRepository->save($dessert, true);

            return $this->redirectToRoute('app_crud_dessert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/Plats/crud_dessert/new.html.twig', [
            'dessert' => $dessert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_dessert_show', methods: ['GET'])]
    public function show(Dessert $dessert): Response
    {
        return $this->render('/AdminTemplate/Crud/Plats/crud_dessert/show.html.twig', [
            'dessert' => $dessert,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crud_dessert_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dessert $dessert, DessertRepository $dessertRepository): Response
    {
        $form = $this->createForm(DessertType::class, $dessert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dessertRepository->save($dessert, true);

            return $this->redirectToRoute('app_crud_dessert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/AdminTemplate/Crud/Plats/crud_dessert/edit.html.twig', [
            'dessert' => $dessert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crud_dessert_delete', methods: ['POST'])]
    public function delete(Request $request, Dessert $dessert, DessertRepository $dessertRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dessert->getId(), $request->request->get('_token'))) {
            $dessertRepository->remove($dessert, true);
        }

        return $this->redirectToRoute('app_crud_dessert_index', [], Response::HTTP_SEE_OTHER);
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
              echo "<p class='bs-danger'>cf. CrudBDessertController L124 : La recherche de doublons dans la table Photo n'a pas abouti : " . $e->getTraceAsString() . " </p>";
          };
          return false;
      }

  /**
     * Function fetchDonneesPhoto
     * Return   tabentites[tabentite[dataview [set[binary,titre] ]]]
     */
    function fetchDonneesEntity($entity,$id=null, EntityManagerInterface $em= null ):array{
        if ($id != null) {
            $this->em->getRepository($entity)->findByIdDQL($entity);
        } else {
            $entites = $this->em->getRepository($entity)->findAllDQL($entity);
        }
        $i=0;
        foreach($entites as $entite){        
                 $entites[$i]['dataview']= ['set'=> $this->displayFile( $entite['binaryfile'],$entite['titre'])];
                 $i++;        
            } 
      return $entites;
    }

}
