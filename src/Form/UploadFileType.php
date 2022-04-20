<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uploadFile', FileType::class, [
                'label' => 'Image (PNG ou JPG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/png',
                        'image/jpg'
                    ],
                    'mimeTypesMessage' => 'Le fichier n\'est pas au format PNG ou JPG'
                ]
            ])
            ->add('legend')
            ->add('submit', SubmitType::class, [
                'label' => 'Televerser la photo',
                'attr' => [
                    'class' => 'btn btn-sm btn-primary w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
