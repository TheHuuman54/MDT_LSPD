<?php

namespace App\Form;

use App\Entity\Arrestation;
use App\Entity\Civil;
use App\Entity\JudiciaryCase;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JudiciaryCaseType extends AbstractType
{
    
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


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
            ->add('arrestations', EntityType::class,[
                'class' => Arrestation::class,
                'label' => 'Arrestations',
                'multiple' => true,
                'autocomplete' => true
            ])
            ->add('magistrate', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'label' => 'Magistrats :',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.rank', 'r')
                        ->where('r.name IN (:ranks)')
                        ->setParameter('ranks', ['Juge', 'Procureur', 'Avocat']);
                },
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

    public function findRankByJudiciaryCase(int $judiciaryCaseId): ?string
    {
        $query = $this->createQueryBuilder('jc')
            ->select('r.rank')
            ->leftJoin('jc.magistrate', 'u')
            ->leftJoin('u.rank', 'r')
            ->where('jc.id = :judiciaryCaseId')
            ->setParameter('judiciaryCaseId', $judiciaryCaseId)
            ->setMaxResults(1);

        return $query->getQuery()->getOneOrNullResult();
    }
}
