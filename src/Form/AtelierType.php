<?php

namespace App\Form;

use App\Entity\Atelier;
use App\Entity\Forum;
use App\Entity\Intervenant;
use App\Entity\Salle;
use App\Entity\Secteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AtelierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('duration')
            ->add('description')
            ->add('date_atelier')
            ->add('forum', EntityType::class, [
                'class' => Forum::class,
                'choice_label' => 'theme', // Assuming Forum entity has a 'name' field
                'label' => 'Forum : '
            ])
            ->add('sector', EntityType::class, [
                'class' => Secteur::class,
                'choice_label' => 'name', // Assuming Secteur entity has a 'name' field
                'label' => 'Secteur : '
            ])
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
