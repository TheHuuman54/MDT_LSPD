<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Civil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Civil>
 *
 * @method Civil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Civil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Civil[]    findAll()
 * @method Civil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CivilRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Civil::class);
        $this->paginator = $paginator;
    }

    public function save(Civil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Civil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findWidthSearch(Search $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('f');


        if (!empty($search->string)) {
            $query = $query
                ->andWhere('f.firstname LIKE :name OR f.lastname LIKE :name')
                ->setParameter('name', "%{$search->string}%");
        }

//        if (!empty($search->string)) {
//            $query = $query
//                ->andWhere('f.firstname LIKE :string')
//                ->setParameter('string', "%{$search->string}%");
//        }

        $query->getQuery()->getResult();
        return $this->paginator->paginate($query,$search->page,10);
    }

//    /**
//     * @return Civil[] Returns an array of Civil objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Civil
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
