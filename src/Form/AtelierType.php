<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Ecole;
use App\Entity\Forum;
use App\Entity\Intervenant;
use App\Entity\Salle;
use App\Entity\Secteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AtelierType extends AbstractType
{

    private $security;

    // Injectez le service de sécurité dans le constructeur
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('duration')
            ->add('description')
            ->add('date_atelier')
            ->add('heure', ChoiceType::class, [
                'choices' => [
                    '9h30' => '9 H 30',
                    '10h30' => '10 H 30',
                    '11h30' => '11 H 30',
                ],
                'multiple' => false, // Permet de sélectionner plusieurs options
                'expanded' => false, // false pour une liste déroulante, true pour des cases à cocher
            ])
            ->add('forum', EntityType::class, [
                'class' => Forum::class,
                'choice_label' => 'theme', // Assuming Forum entity has a 'name' field
                'label' => 'Forum : '
            ])
            ->add('sector', EntityType::class, [
                'class' => Secteur::class,
                'choice_label' => 'name', // Assuming Secteur entity has a 'name' field
                'label' => 'Secteur : '
            ]);
            $user = $this->security->getUser();
            if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
                // Ajoutez le champ 'ecole' pour les admins avec une liste d'écoles
                $builder->add('ecole', EntityType::class, [
                    'class' => Ecole::class,
                    'choice_label' => 'name', // Adaptez selon votre entité Ecole
                ]);
            } else {
                // Pour les établissements, définissez l'école automatiquement
                // Adaptez cette partie selon la manière dont vous récupérez l'école de l'utilisateur
                $ecole = $user->getEcoles()->first();
                $builder->add('ecole', EntityType::class, [
                    'class' => Ecole::class,
                    'choice_label' => 'name',
                    'disabled' => true,
                    'data' => $ecole,
                ]);
            };
            $builder
            ->add('room', EntityType::class, [
                'class' => Salle::class,
                'choice_label' => 'name', // Assuming Salle entity has a 'name' field
                'label' => 'Salle : '
            ])
            ->add('intervenant', EntityType::class, [
                'class' => Intervenant::class,
                'choice_label' => 'name', // Assuming Intervenant entity has a 'name' field
                'label' => 'Intervenant : '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Atelier::class,
        ]);
    }
}
