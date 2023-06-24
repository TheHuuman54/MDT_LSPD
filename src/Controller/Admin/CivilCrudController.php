<?php

namespace App\Controller\Admin;

use App\Entity\Civil;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CivilCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Civil::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
