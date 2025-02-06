<?php

namespace App\Form;

use App\Entity\Tournament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du tournoi'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('cashprice', NumberType::class, [
                'label' => 'Prix en argent'
            ])
            ->add('nbMaxTeam', NumberType::class, [
                'label' => 'Nombre maximum d\'équipes'
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date du tournoi'
            ])
            ->add('start_inscription', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début des inscriptions'
            ])
            ->add('end_inscription', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin des inscriptions'
            ])
            ->add('finished', CheckboxType::class, [
                'label' => 'Tournoi terminé ?',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournament::class,
        ]);
    }
}

