<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Identifiant'
            ])
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prenom'
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom'
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe'
            ])
            ->add('roleChoice', ChoiceType::class, [
                'mapped' => false,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-check'
                ],
                'label' => 'Type de compte',
                'choices' => [
                    'Client' => 'ROLE_CLIENT',
                    'Photographe' => 'ROLE_PHOTO'
                ]
            ])
            ->add('btnSubmit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-primary w-100'
                ],
                'label' => 's\'inscrire'
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
