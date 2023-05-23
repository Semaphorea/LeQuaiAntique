<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\DateType; 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Horaires;
use Doctrine\ORM\EntityManagerInterface;


class ReservationFormType extends AbstractType
{  

  private  EntityManagerInterface $em; 

    public function __construct(EntityManagerInterface $em){ 
        $this->em= $em;
    }

    public function buildForm(FormBuilderInterface $builder,  array $options): void  
    {  
        $horairesRepository= $this->getEntityManager()->getRepository(Horaires::class);
        
        $horaire= $horairesRepository->findAll(); 
        
        // var_dump($horaire[0]->getDejeunerDebut()); 
        $nbQuartMidi =  $this->getQuartdHeure($horaire[0]->getDejeunerDebut(),$horaire[0]->getDejeunerFin());        
        $nbQuartSoir =  $this->getQuartdHeure($horaire[0]->getDinerDebut(),$horaire[0]->getDinerFin());          
        $quartMidi   =  $this->getTabQuart($horaire[0]->getDejeunerDebut(), $nbQuartMidi);
        $quartSoir   =  $this->getTabQuart($horaire[0]->getDinerDebut(), $nbQuartSoir);
        
        
         
        $builder    
        ->setAction('réservation')
        ->setMethod('POST')          
            ->add('Arrivee', DateType::class,['attr'=>['class'=>' form-control, col-2 m-3','style'=>'display:inline-block'], 'label_attr'=>['style'=>'display:inline-block'] ,'widget'=>'single_text','years'=>range(date('Y'),date('Y')+5) ,'placeholder'=>['year'=>'Année','month'=>'Mois','day'=>'Jour'],'required' => true])
            ->add('Nombre_Adultes',ChoiceType::class,['choices'=> $this->getEffectifs(100),'placeholder'=>' ','attr'=>['class'=>'  md-form-control  col-1 m-3 '],'multiple'=>false,'expanded'=>false,'mapped'=>true, 'required' => true]) 
            ->add('Nombre_Enfants',ChoiceType::class,['choices'=> $this->getEffectifs(100),'attr'=>['class'=>' md-form-control  col-1 m-3'],'multiple'=>false,'mapped'=>true, 'required' => false])               
            ->add('IntolerancesAlimentaires',ChoiceType::class,[ 'label'=>'Intolérance Alimentaire (Plusieurs choix possibles avec Ctrl)','label_attr'=>['style'=>'display:block'],'choices'=>['gluten'=>'gluten','histamine'=>'histamine' ,'lactose'=>'lactose','sucre'=>'saccharose','tyramine'=>'tyramine'],'attr'=>['class'=>' md-form-control col-2 m-3 p-2'], 'expanded' => false,'multiple'=>true,'mapped'=>true, 'required' => false])
        ;    
        

   
        $builder->add('Horaire_Midi', ChoiceType::class, [
            'expanded' => true,
            'multiple' => false,
            'choices' => $quartMidi,  
            'attr'=>     ['class'=>'radiobutton'],   
            'placeholder' => false,
            'required' => true,
           
        ]);  

     

             
        $builder->add('Horaire_Soir', ChoiceType::class, [
            'attr'=>     ['class' => 'radiobutton'],     
            'choices' => $quartSoir,
            'expanded' => true,  
            'multiple' => false,     
            'placeholder' => false,
            'required' => true,
            
        ]);    
  
        $builder ->add('Remarques',TextType::class ,['attr'=>['class'=>' md-form-control  col-2 m-3']]) 
                 ->add('Reserver',SubmitType::class,['label'=>'Réserver','attr'=>['class'=>'btn btn-danger  float-start control col-2 m-3 d-inline-block','formaction'=>'\reservation\reserver','onClick'=>'document.getElementsByTagName("form")[0].submit()']]) 
                 ->add('Modifier',SubmitType::class,['validation_groups'=>'modifier','attr'=>['class'=>'btn btn-danger  md-form-control col-2 m-3 mb-3 d-inline-block','formaction'=>'\reservation\modifier','onClick'=>'document.getElementsByTagName("form")[0].submit()']]) ;
                

    } 

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }

        

        function getEffectifs(int $effectif){
            $tab=[];
            for($i=1;$i<=$effectif; $i++){$tab[$i]=$i;} 
            return $tab;
        }

        /**
         * getQuartdHeure()
         * @Param $a: heure de début
         * @Param $b: heure de fin 
         */
        function getQuartdHeure($a,$b){
            $interval = new \DateInterval('PT1H');  //Les repas ne sont plus servis 1 heure avant la fermeture donc nous retirons celle-ci.
            $b=$b->sub($interval);
            $res=$b->diff($a);
            $res=($res->h+$res->i)*60/15;
            return $res;
        }  

        /**   
         * getTabQuart()
         * @Param $deb 
         * @Param $a : nb de quart d'heure
         * TODO:bug: Il y a ajout ou suppression de minutes
         */
         function getTabQuart($deb,$a){
            //  var_dump($a);
            $horaire = [date('H:i',$deb->getTimestamp()) =>date('H:i',$deb->getTimestamp())];
            $timeAjout=mktime(0,15);
            $temp=$deb->getTimestamp();
            for ( $i = 1 ; $i < ($a+1); $i++ ){
             
               
                    // var_dump('L152 : '.$temp.' '. mktime(0,15));
                    $temp=$temp+$timeAjout;  
                         //  print_r(date('H:i',$temp));

                    $tempformate=date('H:i',$temp) ; 
                     $horaire[$i]=[$tempformate => $tempformate] ; 
                   
            
            
            } 
            //print_r($horaire);
            return $horaire;
         }
    function getEntityManager(){return $this->em;}
}
