<?php

namespace App\Controller\Admin;

use App\Entity\Arrestation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArrestationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Arrestation::class;
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
