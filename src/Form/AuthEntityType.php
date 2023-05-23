<?php

namespace App\Form;

use App\Entity\AuthEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AuthEntityType extends AbstractType
{

   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


       
        $builder 
            ->add('roles',TextType::class ,['attr'=>['class'=>'form-control']])
            ->add('email',EmailType::class ,['attr'=>['class'=>'form-control']])
            ->add('password', PasswordType::class, ['attr' => ['class' => ' form-control,  m-2'],'mapped'=>false])
            ->add('passwordconfirmation', PasswordType::class, ['attr' => ['class' => ' form-control,  m-2'],'mapped'=>false])
            ->add('Client')
            ->add('Administrateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AuthEntity::class,
        ]);
    }
}
