<?php

namespace App\Form;

use App\Entity\Formule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Entree;
use App\Entity\PlatPrincipal;
use App\Entity\Dessert;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FormuleType extends AbstractType
{


    private  EntityManagerInterface $em; 
    private  $ensemblePlats;

    public function __construct(EntityManagerInterface $em){ 
        $this->em= $em;
        $this->ensemblePlats=[];
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $entree=[];$plat=[];$dessert=[];
        array_push($entree,$this->getEntityManager()->getRepository(Entree::class)->findAll());
        array_push($plat,$this->getEntityManager()->getRepository(PlatPrincipal::class)->findAll());
        array_push($dessert,$this->getEntityManager()->getRepository(Dessert::class)->findAll());
        
        $entrees= ['entrees', $entree];
        $plats=['plats',$plat];
        $desserts=['desserts', $dessert];

       $this->getEntreePlats($entrees,$plats,$desserts);
   
  
   
    

        $builder
            ->add('Titre',TextType::class ,['attr'=>['class'=>'form-control col-5']])
            ->add('Description',TextType::class ,['attr'=>['class'=>'form-control col-5']])
            ->add('Plats',ChoiceType::class,['attr'=>['class'=>'form-control col-5','extended'=>false,'multiple'=>true], 'choices'=>[$this->ensemblePlats]])
            ->add('Prix',NumberType::class ,['attr'=>['class'=>'form-control col-5']])
            ->add('Menu',TextType::class ,['attr'=>['class'=>'form-control col-5']])
            ->add('DateApplication',TextType::class ,['attr'=>['class'=>'form-control col-5', 'placeholder'=>'jj/mm/aaaa au jj/mm/aaa']])
        ;
    }  

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formule::class,
        ]);
    }

    function getEntityManager(){return $this->em;}


    /**
     * Function getEntreePlats
     * Arg Plats ['Categories',Plat[]]
     * Return [Categorie [ Titre => Id]]
     */
    function getEntreePlats(...$inputs){
      
       $m=0;
       $tab=[]; 
        foreach($inputs as $in){    
              
          $typeplat=$in[0]; 
          $tab2=[];$tabIntermediaire=[];
            for($i=0;$i<count($in[1]);$i++){
                  
                $entity=$in[1][0];                
                   for($l=0;$l<count($entity);$l++){
                   $tab2[$l]=[ $entity[$l]->getTitre() => $entity[$l]->getId() ];
                }
                }
                array_push($tab, [ucfirst($typeplat)  => $tab2]);               
               
                $this->ensemblePlats=$tab;
                
           $m++;
        }
          
           dump($this->ensemblePlats);
         
           }
       }

