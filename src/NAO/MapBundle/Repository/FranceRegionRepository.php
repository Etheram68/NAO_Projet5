<?php

namespace NAO\MapBundle\Repository;

use Doctrine\ORM\EntityRepository;
use NAO\MapBundle\Entity\FranceRegion;

/**
 * Class FranceRegionRepository
 * @package NAO\MapBundle\Repository
 */
class FranceRegionRepository extends EntityRepository
{
    public function getAll($offset,$limit = 50)
    {
        $query = $this->createQueryBuilder('f')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit )
            ->getQuery();
        return $query->getResult();
    }

    /**
     * @param $city
     * @return array
     */
    public function autocompleteByCity($city)
    {
        return $this->createQueryBuilder('r')
            ->select('r.city AS city', 'r.postcode AS code')
            ->where('r.city LIKE :pattern')->setParameter('pattern', ''.$city.'%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $latitude
     * @param $longitude
     * @param $requestedDistance
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDistanceByCoordinate($latitude, $longitude, $requestedDistance)
    {
        return $this->createQueryBuilder('l')
            ->select('l')
            ->addSelect(
                '( 3959 * acos(cos(radians(' . $latitude . '))' .
                '* cos( radians( l.latitude ) )' .
                '* cos( radians( l.longitude )' .
                '- radians(' . $longitude . ') )' .
                '+ sin( radians(' . $latitude . ') )' .
                '* sin( radians( l.latitude ) ) ) ) as distance', 'l.city AS city', 'l.postcode AS code'
            )
            ->having('distance < :distance')
            ->setParameter('distance', $requestedDistance)
            ->orderBy('distance', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
