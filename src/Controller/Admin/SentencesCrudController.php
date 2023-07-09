<?php

namespace App\Controller\Admin;

use App\Entity\Sentences;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SentencesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sentences::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('article', 'Article (ex : "1CR-13") :'),
            TextField::new('name', 'Nom du fait commis :'),
            IntegerField::new('money', 'Montant de l\'amende'),
            AssociationField::new('category', 'Gravité du fait commis :'),
            IntegerField::new('gavTime', 'Temps de G.A.V'),
            BooleanField::new('avocat', 'Nécessite un Avocat ?'),
            BooleanField::new('Procureur', 'Nécessite un Procureur ?'),
            BooleanField::new('Judge', 'Nécessite un Juge ?'),
            TextAreafield::new('action', 'Action a effectué après l\'arrestation :')

        ];
    }
}
