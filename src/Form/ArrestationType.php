<?php

namespace App\Form;

use App\Entity\Arrestation;
use App\Entity\Category;
use App\Entity\Civil;
use App\Entity\Pictures;
use App\Entity\Sentences;
use App\Entity\User;
use App\Repository\SentencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
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
            ->add('date', DateTimeType::class, [
                'label'=> 'Date d\'arrestation :',
                'data' => new \DateTime('now'),
                ])
            ->add('agent', EntityType::class, [
                'class' => User::class,
                'label' => 'Agent(s) présents :',
                'multiple' => true,
                'autocomplete' => true,
            ])

            ->add('suspect', EntityType::class,[
                'class' => Civil::class,
                'label' => 'Suspect :',
                'autocomplete' => true
            ])
            ->add('justicePicture', FileType::class, [
                'label' => 'Photos d\'arrestations',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('observation', TextareaType::class, [
                'label' => 'Observations',
                'required'=> false
            ])
            ->add('gavStart', DateTimeType::class, [
                'label' => 'Début de G.A.V :',
                'data' => new \DateTime('now'),
            ])
            ->add('gavEnd', DateTimeType::class, [
                'label' => 'Fin de G.A.V :',
                'data' => new \DateTime('now'),
            ])
            ->add(
                'sentences',
                EntityType::class,
                [
                    'class' => Sentences::class,
                    'label' => "Faits Commis",
                    'multiple' => true,
                    'group_by' => 'category',
                    'autocomplete' => true
                ])
            ->add('saisis', TextType::class,[
                'label' => 'Saisis (insérer le lien discord de la saisis effectué'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Arrestation::class,
        ]);
    }

    private function getSentencesList():array
    {
        $sentences = $this->em->getRepository(Sentences::class)->createQueryBuilder('u')
                      //->select("CONCAT(u.name,' ( ', c.name, ' )') as name, u.id as id")
                      ->select("u.name as name, u as id, c.name as category_name")
                      ->join(Category::class, 'c', 'WITH', 'u.category = c.id')
                       ->orderBy('u.category', 'ASC')
                        ->getQuery()->getResult();

        $arraySentence = [];

        foreach($sentences as $sentence)
        {
            $arraySentence[$sentence['category_name']][$sentence['name']] = $sentence['id'];
        }
//        foreach($sentences as $sentence)
//        {
//            $arraySentence[$sentence['name']] = $sentence['id'];
//        }

        //dd($arraySentence);

        return $arraySentence;
    }
}
