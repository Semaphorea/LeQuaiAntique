<?php

namespace App\Form;

use App\Entity\Entree;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Titre',TextType::class ,['attr'=>['class'=>'form-control']])
        ->add('Description',TextType::class ,['attr'=>['class'=>'form-control']])
        ->add('Prix',NumberType::class ,['attr'=>['class'=>'form-control']])  
        ->add('Photo', FileType::class, [
                'label' => 'Photo file',
                 'mapped' => false,
                 'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'extensions'=> ['jpg','jpeg','png'], 
                        'mimeTypesMessage' => 'Please upload a valid Photo file',
                    ])
                ],
            ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entree::class,
        ]);
    }
}
