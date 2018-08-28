<?php

namespace NAO\GameBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;


/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends EntityRepository
{

    public function myFindAll()
    {

        $queryBuilder = $this->createQueryBuilder('q')
            ->addSelect('RAND() as HIDDEN Rand')
            ->orderBy('Rand()')
        ->setMaxResults(5);


        $query= $queryBuilder->getQuery();

        $results = $query->getResult();

        return $results;
    }

}
