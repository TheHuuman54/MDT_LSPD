<?php

namespace App\Form;

use App\Entity\Civil;
use App\Entity\Ethnie;
use App\Entity\Gender;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('idUnique', IntegerType::class, [
                'label' => 'ID UNIQUE',
            ])
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
            ->add('type', EntityType::class, [
                'class' => Ethnie::class,
                'label' => 'Type du Civil'
            ])
            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'label' => 'Genre',
                'multiple' => false,
                'expanded' => true
            ])

            ->add('age', IntegerType::class, [
                'label' => 'Âge'
            ])
            ->add('telNumber', TextType::class, [
                'label' => 'Numéro de téléphone',
                'required' => false
            ])
            ->add('documents', FileType::class, [
                'label' => 'Carte d\'identité / Permis de Conduire / PPA',
                'multiple'=> true,
                'mapped' => false,
                'required' => false
            ])
            ->add('PPA', ChoiceType::class, [
                'label' => 'Validité du PPA',
                'choices' => [
                    'Valide' => 1,
                    'Invalide' => 0
                ],
                'expanded' => 'true',
                'multiple' => false
            ])
            ->add('driveCard', ChoiceType::class, [
                'label' => 'Validité du permis de conduire',
                'choices' => [
                    'Valide' => 1,
                    'Invalide' => 0
                ],
                'expanded' => 'true',
                'multiple' => false
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
