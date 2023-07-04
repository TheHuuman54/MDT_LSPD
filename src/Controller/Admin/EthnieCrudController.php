<?php

namespace App\Controller\Admin;

use App\Entity\Ethnie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EthnieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ethnie::class;
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
