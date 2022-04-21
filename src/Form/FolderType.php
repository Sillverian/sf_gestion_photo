<?php

namespace App\Form;

use App\Entity\Folder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FolderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('folderName', TextType::class, [
                'label' => 'Nom du dossier',
                'required' => false
            ])
            ->add('parentFolder', EntityType::class, [
                'class' => Folder::class,
                'choice_label' => 'folderName',
                'label' => "Nom du sous dossier"
            ])
            ->add('btnSubmit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-primary w-100'
                ],
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Folder::class,
        ]);
    }
}
