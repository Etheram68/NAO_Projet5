<?php

namespace NAO\FicheBundle\Repository;
use NAO\MapBundle\Entity\Bird;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityRepository;

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
        $query = $this->createQueryBuilder('b')
            ->where('b.status = :status')
            ->setParameter('status', Bird::VALIDATED)
            ->andWhere('b.naturalist = :user')
            ->setParameter('user', $user)
            ->orderBy('b.validated', 'DESC')
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

    /**
     *
     * @return array
     */
    public function getBirdWithFilter($speciment, $department)
    {
        $query = $this->createQueryBuilder('b')
            ->innerJoin('b.taxref', 't')
            ->addSelect('t')
            ->where('b.status = :status')->setParameter('status', Observation::VALIDATED);
        if (!empty($speciment)) {
            $query->andwhere('t.taxon_sc = :specimen')->setParameter('specimen', $speciment);
        }
        $query->orderBy('o.id', 'DESC');
        return $query->getQuery()->getResult();
    }

    public function getMyBird($state, $user, $currentPage, $limit = 50)
    {
        switch ($state) {
            case 'my_draft':
                return $this->getMyDraftBird($user, $currentPage, $limit);
                break;
            case Bird::REFUSED:
                break;
            case 'my_validate':
                return $this->getMyValidateBird($user, $currentPage, $limit);
            case 'my_waiting':
                return $this->getMyWaitingBird($user, $currentPage, $limit);
            case 'waiting':
                return $this->getWaitingValidation($currentPage, $limit);
            case 'refuse':
                return $this->getDeclineValidation($user, $currentPage, $limit);
            case 'my_validatevalidation':
                return $this->getValidateValidation($user, $currentPage, $limit);
        }
    }

    /**
     *
     * @param $currentPage
     * @param int $limit
     * @return Paginator
     */
    public function getMyDraftBird($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.status = :status')
            ->setParameter('status', Bird::DRAFT)
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->orderBy('b.id', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }

    /**
     *
     * @param $currentPage
     * @param int $limit
     * @return Paginator
     */
    public function getMyValidateBird($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.status = :status')
            ->setParameter('status', Bird::VALIDATED)
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->orderBy('b.id', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }

    /**
     *
     * @param $currentPage
     * @param int $limit
     * @return Paginator
     */
    public function getMyWaitingBird($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.status = :status')
            ->setParameter('status', Bird::WAITING)
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->orderBy('b.watched', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }

    /**
     * @param $currentPage
     * @param int $limit
     * @return Paginator
     */
    public function getWaitingValidation($currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.status = :status')
            ->setParameter('status', Bird::WAITING)
            ->orderBy('b.watched', 'ASC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }

    public function getDeclineValidation($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.status = :status')
            ->setParameter('status', Bird::REFUSED)
            ->andWhere('b.naturalist = :user')
            ->setParameter('user', $user)
            ->orderBy('b.validated', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }


}
