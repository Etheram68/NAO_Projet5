<?php

namespace NAO\MapBundle\Repository;

use Doctrine\ORM\EntityRepository;
use NAO\MapBundle\Entity\Observation;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class ObservationRepository
 * @package NAO\MapBundle\Repository
 */
class ObservationRepository extends EntityRepository
{
    public function deleteByUser($user_id)
    {
        $query = $this->createQueryBuilder('o')
            ->delete()
            ->where('o.user = :user_id')
            ->orWhere('o.naturalist = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery();
        return 1 === $query->getScalarResult();
    }

    /**
     * Get validated observation
     *
     * @param $user
     * @param $currentPage
     * @param int $limit
     * @return Paginator
     */
    public function getValidateValidation($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', Observation::VALIDATED)
            ->andWhere('o.naturalist = :user')
            ->setParameter('user', $user)
            ->orderBy('o.validated', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }

    /**
     * Paginator help
     *
     * @param $dql       DQL Query Object
     * @param int $page Current page (defaults to 1)
     * @param int $limit The total number per page (defaults to 50)
     * @return Paginator Object
     */
    public function paginate($dql, $page = 1, $limit = 50)
    {
        $paginator = new Paginator($dql);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))// Offset
            ->setMaxResults($limit); // Limit
        return $paginator;
    }

    /**
     * @param $taxref_id
     * @param $observation_id
     * @return array
     */
    public function getLastObservationForBird($taxref_id, $observation_id)
    {
        return $this->createQueryBuilder('o')
            ->where('o.taxref = :taxref')
            ->setParameter('taxref', $taxref_id)
            ->andWhere('o.status = :status')
            ->setParameter('status', Observation::VALIDATED)
            ->andWhere('o.id != :id')
            ->setParameter('id', $observation_id)
            ->orderBy('o.watched', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $currentPage
     * @param int $limit
     * @return Paginator
     */
    public function getValideObservations($currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', Observation::VALIDATED)
            ->orderBy('o.watched', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }

    /**
     *
     * @return array
     */
    public function getObservationsWithFilter($speciment, $department)
    {
        $query = $this->createQueryBuilder('o')
            ->innerJoin('o.taxref', 't')
            ->addSelect('t')
            ->where('o.status = :status')->setParameter('status', Observation::VALIDATED);
        if (!empty($speciment)) {
            $query->andwhere('t.taxon_sc = :specimen')->setParameter('specimen', $speciment);
        }
        if (!empty($department)) {
            $query->andwhere('o.place LIKE :department')->setParameter('department', '%(' . $department . ')%');
        }
        $query->orderBy('o.watched', 'DESC');
        return $query->getQuery()->getResult();
    }

    public function getMyObservations($state, $user, $currentPage, $limit = 50)
    {
        switch ($state) {
            case 'my_draft':
                return $this->getMyDraftObservations($user, $currentPage, $limit);
                break;
            case Observation::REFUSED:
                break;
            case 'my_validate':
                return $this->getMyValidateObservations($user, $currentPage, $limit);
            case 'my_waiting':
                return $this->getMyWaitingObservations($user, $currentPage, $limit);
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
    public function getMyDraftObservations($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', Observation::DRAFT)
            ->andWhere('o.user = :user')
            ->setParameter('user', $user)
            ->orderBy('o.watched', 'DESC')
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
    public function getMyValidateObservations($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', Observation::VALIDATED)
            ->andWhere('o.user = :user')
            ->setParameter('user', $user)
            ->orderBy('o.watched', 'DESC')
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
    public function getMyWaitingObservations($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', Observation::WAITING)
            ->andWhere('o.user = :user')
            ->setParameter('user', $user)
            ->orderBy('o.watched', 'DESC')
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
        $query = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', Observation::WAITING)
            ->orderBy('o.watched', 'ASC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }

    public function getDeclineValidation($user, $currentPage, $limit = 50)
    {
        $query = $this->createQueryBuilder('o')
            ->where('o.status = :status')
            ->setParameter('status', Observation::REFUSED)
            ->andWhere('o.naturalist = :user')
            ->setParameter('user', $user)
            ->orderBy('o.validated', 'DESC')
            ->getQuery();
        $paginator = $this->paginate($query, $currentPage, $limit);
        return $paginator;
    }
}
