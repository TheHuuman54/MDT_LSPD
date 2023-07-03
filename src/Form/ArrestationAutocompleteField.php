<?php

namespace App\Form;

use App\Entity\Arrestation;
use App\Repository\ArrestationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class ArrestationAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Arrestation::class,
            'placeholder' => 'Choose a Arrestation',
            //'choice_label' => 'name',

            'query_builder' => function(ArrestationRepository $arrestationRepository) {
                return $arrestationRepository->createQueryBuilder('arrestation');
            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
