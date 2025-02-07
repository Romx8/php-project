<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // Affiche l'ID mais ne le laisse pas modifier dans les formulaires
            IdField::new('id')->hideOnForm(),

            // Champ Email
            TextField::new('email', 'Email'),

            // Champs Prénom et Nom
            TextField::new('first_name', 'Prénom'),
            TextField::new('last_name', 'Nom'),

            // Champ Pseudo
            TextField::new('pseudo', 'Pseudo'),

            // Affiche les rôles sous forme de tableau (modifiable si besoin)
            ArrayField::new('roles', 'Rôles'),

            // Champ pour le statut de vérification
            BooleanField::new('isVerified', 'Vérifié'),
        ];
    }
}
