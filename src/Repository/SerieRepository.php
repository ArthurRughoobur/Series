<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findBestSeries(int $page = 1)
    {
        //DQL
//        $dql = "
//            SELECT s, seasons  FROM App\Entity\Serie AS s
//            LEFT JOIN  s.seasons AS seasons
//            ORDER BY s.popularity DESC
//            ";
        //$query = $this->getEntityManager()->createQuery($dql);

        $qb = $this->createQueryBuilder('s');
        $qb->addOrderBy('s.popularity', 'DESC');
        //jointure + select
        $qb->leftJoin('s.seasons', 'seasons');
        $qb->addSelect('seasons');

        $query = $qb->getQuery();
        $query->setMaxResults(50);
        $offset = ($page - 1) * 50;
        $query->setFirstResult($offset);
        //permet de gérer la pagination sur jointure
        $paginator = new Paginator($query);
        return $paginator;
    }
}
