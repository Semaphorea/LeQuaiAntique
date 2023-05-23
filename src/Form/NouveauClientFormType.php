<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\AuthEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class NouveauClientFormType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAction('nouveauclient')      
            ->setMethod('POST')
            
            ->add('Nom', TextType::class, ['attr' => ['class' => ' form-control, m-2  flex justify-content-between width-100']])
            ->add('Prenom', TextType::class, ['attr' => ['class' => ' form-control,  m-2 ']])
            ->add('Email', EmailType::class, ['attr' => ['class' => ' form-control,  m-2 ']])
            ->add('password', PasswordType::class, ['attr' => ['class' => ' form-control,  m-2','autocomplete'=>"current-password"] ])  
            ->add('passwordconfirmation', PasswordType::class, ['label'=>'Password Confirmation','attr' => ['class' => ' form-control,  m-2' ,'autocomplete'=>"current-password"]])
            ->add('nbConvive', ChoiceType::class, ['label' => 'Nombre de Couverts', 'choices' => $this->getEffectifs(100), 'attr' => ['class' => ' form-control  col-1 m-2 '], 'multiple' => false, 'required' => false])
            ->add('IntolerancesAlimentaires', ChoiceType::class, ['label' => 'Intolérances Alimentaires  (Plusieurs choix possibles avec Ctrl)', 'label_attr' => ['style' => 'display:block'], 'choices' => ['gluten' => 'gluten', 'histamine' => 'histamine', 'lactose' => 'lactose', 'sucre' => 'saccharose', 'tyramine' => 'tyramine'], 'attr' => ['class' => ' form-control  m-2 p-2 '], 'expanded' => false, 'multiple' => true, 'required' => false])
            ->add('Submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary  form-control  form-control m-5 ']]);
             
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }


    function getEffectifs(int $effectif)
    {
        $tab = [];
        for ($i = 1; $i <= $effectif; $i++) {
            $tab[$i] = $i;
        }
        return $tab;
    }
}
