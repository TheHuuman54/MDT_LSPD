<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Arrestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Arrestation>
 *
 * @method Arrestation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arrestation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arrestation[]    findAll()
 * @method Arrestation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArrestationRepository extends ServiceEntityRepository
{

    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Arrestation::class);
        $this->paginator = $paginator;
    }

    public function save(Arrestation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Arrestation $entity, bool $flush = false): void
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
//     * @return Arrestation[] Returns an array of Arrestation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Arrestation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
