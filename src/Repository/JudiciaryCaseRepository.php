<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\JudiciaryCase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<JudiciaryCase>
 *
 * @method JudiciaryCase|null find($id, $lockMode = null, $lockVersion = null)
 * @method JudiciaryCase|null findOneBy(array $criteria, array $orderBy = null)
 * @method JudiciaryCase[]    findAll()
 * @method JudiciaryCase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JudiciaryCaseRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, JudiciaryCase::class);
        $this->paginator = $paginator;
    }

    public function save(JudiciaryCase $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JudiciaryCase $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findWidthSearch(Search $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('a')
            ->join('a.suspect', 'c');

        if (!empty($search->string)) {
            $query = $query
                ->andWhere('c.firstname LIKE :string')
                ->setParameter('string', "%{$search->string}%");
        }

        /* if (!empty($search->nationalities)) {
             $query = $query
                 ->andWhere('hi.country IN (:country)')
                 ->setParameter('country', $search->nationalities);
         }*/

        $query->getQuery()->getResult();
        return $this->paginator->paginate($query,$search->page,10);
    }

//    /**
//     * @return JudiciaryCase[] Returns an array of JudiciaryCase objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JudiciaryCase
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
