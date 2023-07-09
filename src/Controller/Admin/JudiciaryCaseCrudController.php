<?php

namespace App\Controller\Admin;

use App\Entity\JudiciaryCase;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class JudiciaryCaseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JudiciaryCase::class;
    }

//    public function configureFields(string $pageName): iterable
//    {
//        return [
//            IdField::new('id'),
//            TextField::new('title'),
//            TextEditorField::new('description'),
//        ];
//    }

}
