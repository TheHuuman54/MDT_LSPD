<?php

namespace App\Form;

use App\Entity\Rank;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'constraints' => new Length(null,7,60),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse email'
                ]
            ])
            ->add('idUnique', IntegerType::class, [
                'label' => 'Votre Identifiant Unique',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre Identifiant Unique'
                ]
            ])
            ->add('matricule', TextType::class, [
                'label' => 'Votre matricule',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre Matricule'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre mot de passe'
                    ]
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prénom',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre Prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre Nom'
                ]
            ])
            ->add('rank', EntityType::class, [
                'label' => 'Votre grade actuelle',
                'class' => Rank::class,
                'choice_label' => function($rank) {
                    return $rank->getName();
                }
            ])
            ->add('telNumber', TelType::class, [
                'label' => 'Votre numéro de téléphone',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre numéro de téléphone'
                ]
            ])
            ->add('Submit', SubmitType::class, [
                'label' => 'S\'inscrire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
