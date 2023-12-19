<?php

namespace App\Form;

use App\Entity\Ecole;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userType', ChoiceType::class, [
                'label' => 'Type d\'utilisateur',
                'choices' => [
                    'Etudiant' => 'etudiant',
                    'Etablissement' => 'ecole',
                ],
                'expanded' => true, // affiche les boutons radio
                'multiple' => false, // permet de sélectionner une seule option,
                'mapped'=> false,
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez entrer votre adresse email.',
                    ]),
                    new Assert\Email([
                        'message' => 'L\'adresse email "{{ value }}" n\'est pas une adresse email valide.',
                        'mode' => 'html5',
                    ]),
                ],
            ])
            ->add('ecole', EntityType::class, [
                'mapped' => false,
                'class' => Ecole::class,
                'choice_label' => 'name', // Assuming Forum entity has a 'name' field
                'label' => 'Ecole : '
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Mot de passe',
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('name', TextType::class, [
                'mapped' => false,
                'label' => 'Nom complet',
            ])

            ->add('adress', TextType::class, [
                    'mapped' => false,
                    'label' => 'Adresse',
                    'required' => false,
                ])

            ->add('unique_info', TextType::class, [
                    'mapped' => false,
                    'label' => 'Infomations Personnelles',
                    'required' => false,
                ])

            ->add('school_info', TextType::class, [
                    'mapped' => false,
                    'label' => 'Infomations école',
                    'required' => false,
                ]);  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
