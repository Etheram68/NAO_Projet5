<?php

namespace NAO\MapBundle\Repository;

use Doctrine\ORM\EntityRepository;
use NAO\MapBundle\Entity\Taxref;

/**
 * Class TaxrefRepository
 * @package NAO\MapBundle\Repository
 */
class TaxrefRepository extends EntityRepository
{
    /**
     * Get Autocomplete name
     * @param $name
     * @return array
     */
    public function autocompleteByCommonName($name)
    {
        return $this->createQueryBuilder('t')
            ->select('t.common_name AS text', 't.taxon_sc AS latin')
            ->where('t.common_name LIKE :pattern')->setParameter('pattern', ''.$name.'%')
            ->getQuery()
            ->getResult();
    }
}
