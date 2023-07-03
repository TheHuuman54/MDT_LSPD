<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('idUnique','ID Unique'),
            TextField::new('matricule', 'Matricule'),
            ArrayField::new('roles', 'Permissions')->setPermission('ROLE_SUPER_ADMIN'),
            AssociationField::new('rank','Rang'),
            TextField::new('firstname','Prénom'),
            TextField::new('lastname', 'Nom'),
            TextField::new('telNumber', 'Numéro de téléphone'),
            EmailField::new('email','Adresse Email'),
            TextField::new('password','Mot de passe')
        ];
    }
}
