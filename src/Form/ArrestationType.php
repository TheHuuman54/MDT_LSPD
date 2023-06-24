<?php

namespace App\Form;

use App\Entity\Arrestation;
use App\Entity\Civil;
use App\Entity\Pictures;
use App\Entity\Sentences;
use App\Repository\SentencesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ArrestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class, [
                'label'=> 'Date d\'arrestation',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute',
                ]
                ])
            ->add('suspect', EntityType::class,[
                'class' => Civil::class,

            ])
            ->add('justicePicture', FileType::class, [
                'label' => 'Photos d\'arrestations',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('observation', TextareaType::class, [
                'label' => 'Observations'
            ])
            ->add('gavStart', DateTimeType::class, [
                'label' => 'Début de G.A.V'
            ])
            ->add('gavEnd', DateTimeType::class, [
                'label' => 'Fin de G.A.V'
            ])
            ->add('sentences', EntityType::class, [
                'class' => Sentences::class,
                'query_builder' => function (SentencesRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');

                },
                'label' => 'Faits Commis',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Arrestation::class,
        ]);
    }
}
