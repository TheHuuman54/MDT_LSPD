<?php

namespace App\Form;

use App\Entity\Civil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CivilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Prénom du civil'
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom du civil'
                ],
            ])
            ->add('height', IntegerType::class, [
                'label' => 'Taille(cm)'
            ])
            ->add('idUnique', IntegerType::class, [
                'label' => 'ID UNIQUE'
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Âge'
            ])
            ->add('telNumber', TextType::class, [
                'label' => 'Numéro de téléphone'
            ])
            ->add('documents', FileType::class, [
                'label' => 'Carte d\'identité / Permis de Conduire / PPA',
                'multiple'=> true,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Civil::class,
        ]);
    }
}
