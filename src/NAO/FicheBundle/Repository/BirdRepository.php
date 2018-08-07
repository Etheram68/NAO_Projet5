<?php

namespace NAO\FicheBundle\Repository;
use NAO\MapBundle\Entity\Bird;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class BirdRepository
 * @package NAO\FicheBundle\Repository
 */
class BirdRepository extends EntityRepository
{
    /**
     * @param $user
     * @param $currentPage
     * @param int $limit
     * @return Paginator
     */
    public function getValidateValidation($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', Bird::VALIDATED)
            ->andWhere('o.naturalist = :user')
            ->setParameter('user', $user)
            ->orderBy('o.validated', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }

    /**
     * @param $dql
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function paginate($dql, $page = 1, $limit = 50)
    {
        $paginator = new Paginator($dql);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))// Offset
            ->setMaxResults($limit); // Limit
        return $paginator;
    }

    public function getLastBirdForBird($taxref_id, $bird_id)
    {
        return $this->createQueryBuilder('b')
            ->where('b.taxref = :taxref')
            ->setParameter('taxref', $taxref_id)
            ->andWhere('b.status = :status')
            ->setParameter('status', Bird::VALIDATED)
            ->andWhere('b.id != :id')
            ->setParameter('id', $bird_id)
            ->orderBy('b.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getValideBird($currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.status = :status')
            ->setParameter('status', Bird::VALIDATED)
            ->orderBy('b.id', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }


}
