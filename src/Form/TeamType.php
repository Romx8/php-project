<?php
// src/Form/TeamType.php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         $builder
             ->add('name', TextType::class, [
                  'label' => 'Nom de l\'équipe',
             ])
             ->add('nbMaxUser', IntegerType::class, [
                  'label' => 'Nombre maximum d\'utilisateurs',
             ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
         $resolver->setDefaults([
             'data_class' => Team::class,
         ]);
    }
}
