<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Formule;



class MenuType extends AbstractType
{

 

   private  EntityManagerInterface $em; 

   public function __construct(EntityManagerInterface $em){ 
       $this->em= $em;
   }

    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {

        $formuleRepository= $this->getEntityManager()->getRepository(Formule::class);
       
       
        
       $formules=$formuleRepository->findAll();
       
       $formuleChoices=[];
       foreach($formules as $formule){
           $formuleChoices=[$formule->getTitre().' : '.$formule->getDescription()=> $formule->getId()];
       }
         
        $builder
            ->add('Titre',TextType::class ,['attr'=>['class'=>'form-control']])
            ->add('Formule',ChoiceType::class,['attr'=>['class'=>'form-control','expanded'=>true,'multiple'=>true],'choices'=>$formuleChoices ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }

    function getEntityManager(){return $this->em;}
}
