<?php

namespace FinquesFarnos\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CityRepository class
 *
 * @category Repository
 * @package  FinquesFarnos\AppBundle\Repository
 * @author   David Romaní <david@flux.cat>
 */
class CityRepository extends EntityRepository
{
    /**
     * Get enabled items sorted by name array result
     *
     * @return array
     */
    public function getEnabledItemsSortedByNameArrayResult()
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.name')
            ->where('c.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
