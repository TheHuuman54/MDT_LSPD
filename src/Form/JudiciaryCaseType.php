<?php

namespace App\Form;

use App\Entity\Civil;
use App\Entity\JudiciaryCase;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JudiciaryCaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class,[
                'label' => 'Date de la demande :',
                'data' => new \DateTime('now'),

            ])
            ->add('decision', TextareaType::class, [
                'label' => 'Décision de Justice :'
            ])
            ->add('suspect', EntityType::class, [
                'class' => Civil::class,
                'label' => 'Identitié du suspect :',
                'autocomplete' => true
            ])
            ->add('magistrate', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'label' => 'Magistrats :',
                'autocomplete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JudiciaryCase::class,
        ]);
    }
}
