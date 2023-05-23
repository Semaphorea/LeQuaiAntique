<?php

namespace App\Form;

use App\Entity\Horaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class HorairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        $builder
            ->add('DejeunerDebut', DateTimeType::class,['attr'=>['class'=>' horaire  d-grid d-inline-grid m-2 p-2 w-100 ' ],'years'=>range(date('Y'),date('Y')+5) ,'placeholder'=>['year'=>'Année','month'=>'Mois','day'=>'Jour']])
            ->add('DejeunerFin', DateTimeType::class,['attr'=>['class'=>' horaire d-grid d-inline-grid m-2 p-2 w-100' ],'years'=>range(date('Y'),date('Y')+5) ,'placeholder'=>['year'=>'Année','month'=>'Mois','day'=>'Jour']]) 
            ->add('DinerDebut', DateTimeType::class,['attr'=>['class'=>' horaire d-grid d-inline-grid m-2 p-2 w-100' ],'years'=>range(date('Y'),date('Y')+5) ,'placeholder'=>['year'=>'Année','month'=>'Mois','day'=>'Jour']]) 
            ->add('DinerFin', DateTimeType::class,['attr'=>['class'=>' horaire d-grid d-inline-grid m-2 p-2 w-100' ],'years'=>range(date('Y'),date('Y')+5) ,'placeholder'=>['year'=>'Année','month'=>'Mois','day'=>'Jour']]) 
            ->add('Active', ChoiceType::class,['choices'=>['true'=>'1','false'=>'0'],'attr'=>['expanded'=>false,'multiple'=>false]])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horaires::class,
        ]);
    }
}
