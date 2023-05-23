<?php

namespace App\Form;

use App\Entity\Administrateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdministrateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('Nom', TextType::class ,['attr'=>['class'=>'form-control']]) 
             ->add('Prenom', TextType::class ,['attr'=>['class'=>'form-control']])
             ->add('username', HiddenType::class ,['attr'=>['class'=>'form-control', 'value'=>'username']])  
             ->add('email', TextType::class ,['attr'=>['class'=>'form-control']])
             ->add('password', PasswordType::class, ['attr'=>['class'=>'form-control']])
           
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Administrateur::class,
        ]);
    }
}
