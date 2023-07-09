<?php

namespace App\Controller\Admin;

use App\Entity\Arrestation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArrestationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Arrestation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('date', 'Date d\'arrestation :'),
            TextareaField::new('observation', 'Observation :'),
            DateTimeField::new('gavStart', 'Début de la G.A.V :'),
            DateTimeField::new('gavEnd', 'Fin de la G.A.V :'),
            AssociationField::new('suspect', 'Suspect'),
            AssociationField::new('agent', 'Agents Présents'),
            TextField::new('saisis', 'Saisis')
        ];
    }

}
