<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function getAverageRating(Book $book): ?int
    {
        $rating = $this->createQueryBuilder('r')
            ->select('AVG(r.rating)')
            ->where('r.book = :book')->setParameter('book', $book)
            ->getQuery()->getSingleScalarResult()
        ;

        return $rating ? (int) $rating : null;
    }

    public function save(Review $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Review $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findMaxReviewsPeriod($month = false)
    {
        // $query = $this->createQueryBuilder('r')
        //     ->select($month ? 'r.publishedAt AS month' : 'r.publishedAt AS date', 'COUNT(r) AS count')
        //     ->groupBy($month ? 'MONTH(r.publishedAt)' : 'r.publishedAt')
        //     ->orderBy('count', 'DESC')
        //     ->addOrderBy($month ? 'month' : 'date', 'DESC')
        //     ->setMaxResults(1)
        //     ->getQuery()
        //     ->getOneOrNullResult();

        if ($month) {
            $dateFormat = 'Y-m';
            $groupBy = 'DATE_TRUNC(\'month\', r.published_at)';
            $orderBy = 'MAX(r.published_at) DESC';
        } else {
            $dateFormat = 'Y-m-d';
            $groupBy = 'r.published_at';
            $orderBy = 'r.published_at DESC';
        }

        $query = $this->createQueryBuilder('r')
            ->select($month ? 'r.publishedAt As month' : 'r.publishedAt AS date', 'COUNT(r) AS count')
            ->groupBy('r.publishedAt')
            ->orderBy('count', 'DESC')
            ->addOrderBy($month ? 'month' : 'date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();


        return $query ? ($month ? $query['month'] : $query['date']) : null;
    }
}
