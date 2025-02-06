<?php

namespace App\Controller\Admin;

use App\Entity\Encounter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class EncounterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Encounter::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            // L'ID est affiché dans les listes mais masqué dans les formulaires
            IdField::new('id')->hideOnForm(),

            // Champ pour le titre de l'encounter
            TextField::new('title', 'Titre'),

            // Champ pour la description
            TextEditorField::new('description', 'Description'),

            // Optionnel : Afficher les équipes associées à cet encounter (si votre entité possède une association correspondante)
            AssociationField::new('Team', 'Équipes')
                ->setFormTypeOption('by_reference', false)
                ->onlyOnIndex(),
        ];
    }
}
