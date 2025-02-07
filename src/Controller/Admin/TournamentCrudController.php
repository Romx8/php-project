<?php

namespace App\Controller\Admin;

use App\Entity\Tournament;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class TournamentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tournament::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // L'ID est affiché en liste mais masqué dans le formulaire de création/édition
            IdField::new('id')->hideOnForm(),

            // Champs textuels
            TextField::new('name', 'Nom'),
            TextEditorField::new('description', 'Description'),

            // Champs numériques
            NumberField::new('cashprice', 'Prix en argent'),
            NumberField::new('nbMaxTeam', 'Nombre maximum d\'équipes'),

            // Champs de date
            DateField::new('date', 'Date du tournoi'),
            DateField::new('start_inscription', 'Début des inscriptions'),
            DateField::new('end_inscription', 'Fin des inscriptions'),

            // Champ booléen
            BooleanField::new('finished', 'Terminé'),
        ];
    }
}
