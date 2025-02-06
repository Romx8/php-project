<?php

namespace App\Controller\Admin;

use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class TeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Team::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // Affiche l'ID en liste, mais le masque dans les formulaires
            IdField::new('id')->hideOnForm(),

            // Champ pour le nom de l'équipe
            TextField::new('name', 'Nom'),

            // Champ pour le nombre maximum d'utilisateurs dans l'équipe
            NumberField::new('nbMaxUser', 'Nombre maximum d\'utilisateurs'),

            // Optionnel : Afficher la collection des membres (User)
            AssociationField::new('User', 'Membres')
                ->setFormTypeOption('by_reference', false)
                ->onlyOnIndex(),

            // Optionnel : Afficher la collection des tournois inscrits
            AssociationField::new('TournamentId', 'Tournois inscrits')
                ->setFormTypeOption('by_reference', false)
                ->onlyOnIndex(),
        ];
    }
}
