<?php

namespace App\Form; 

use App\Entity\Client;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;  
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use App\Entity\AuthEntity; 
use App\Form\DataTransformer\AuthEntityToNumberTransformer;


class ClientType extends AbstractType
{



    private AuthEntityToNumberTransformer $transformer;

    public function __construct(AuthEntityToNumberTransformer $transformer,
    ) {
        $this->transformer=$transformer;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void 
    {
        $builder    
            ->add('DateTimeCreation',HiddenType::class)             
            ->add('Nom',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('Prenom',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('Email',EmailType::class,['attr'=>['class'=>'form-control']])  
      
            ->add(         
                $builder->create('AuthEntity', AuthEntityType::class,['invalid_message' => 'That is not a valid issue number', 'compound'=>true])
                 
                ->add('password', PasswordType::class,['attr'=>['label'=>'Password','class'=>'form-control']])
                ->add('passwordconfirmation', PasswordType::class,['label'=>'Password Confirmation','attr'=>['class'=>'form-control']])
                ->add('Client',HiddenType::class)
                ->add('Administrateur',HiddenType::class)  
                ->add('roles', HiddenType::class,['attr'=>['empty_data' =>"['ROLE_USER']",'value'=>"['ROLE_USER']"] ])  
                ->add('email', HiddenType::class)
            )      
             
          
            ->add('nbConvive',IntegerType::class,['attr'=>['class'=>'form-control']])  
            ->add('IntolerancesAlimentaires', TextType::class,['attr'=>['label'=>'Intolérances Alimentaires','class'=>'form-control'],'required'=>false])
        ;

         $builder->get('AuthEntity')->addModelTransformer($this->transformer);  

        // DataTimeToStringTransformer permet d'afficher le DateTime sous forme de string
        // Autrement Symfony renvoie une erreur Impossible de transformer DateTime en string
        $builder
            ->get('DateTimeCreation')
            ->addModelTransformer(new DateTimeToStringTransformer());  
    }


    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
