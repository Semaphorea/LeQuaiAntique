<?php

namespace App\Form;

use App\Entity\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $builder
            ->add('Nom', TextType::class,['attr'=>['class'=>'d-grid w-100  md-form-control  ml-5 col-6 m-2', 'style'=>'background-color:#fff'],])
            ->add('Prenom', TextType::class,['attr'=>['class'=>' d-grid w-100   md-form-control  col-6 m-2', 'style'=>'background-color:#fff']])
            ->add('Email',TextType::class,['attr'=>['class'=> 'd-grid w-100 md-form-control  col-6 m-2', 'style'=>'background-color:#fff']])
            ->add('Message',TextareaType::class,['attr'=>['class'=>' d-grid w-100   md-form-control  col-6  m-2', 'style'=>'background-color:#fff']])
            ->add('Submit',SubmitType::class,['attr'=>['class'=>'d-grid w-100  btn btn-danger  md-form-control  col-6 m-2']])  
        ;  
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
