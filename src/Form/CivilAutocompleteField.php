<?php

namespace App\Form;

use App\Entity\Civil;
use App\Repository\CivilRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class CivilAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Civil::class,
            'choice_label' => 'firstname',
            'searchable_fields' => ['firstname'],
            'multiple' => true,
//            'query_builder' => function(CivilRepository $civilRepository) {
//                return $civilRepository->createQueryBuilder('civil');
//            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
