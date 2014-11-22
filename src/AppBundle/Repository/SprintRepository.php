<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Sprint;
use Carbon\Carbon;
use Doctrine\ORM\EntityRepository;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SprintRepository extends EntityRepository
{
    /**
     * @return Sprint
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findSprintToClose()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.expectedClosedAt < :now')
            ->setParameter('now', new \DateTime(Carbon::now()->toDateTimeString()))
            ->andWhere('s.status != \'CLOSE\'')
            ->getQuery()
            ->getSingleResult();
    }
}
