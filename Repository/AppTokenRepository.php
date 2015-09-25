<?php

namespace Clarity\YandexOAuthBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class AppTokenRepository extends EntityRepository
{
    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActiveQB(QueryBuilder $qb = null)
    {
        if (null === $qb) {
            $qb = $this->createQueryBuilder('a');
        }

        return $qb
            ->andWhere('a.expired > :now')
            ->setParameter('now', new \DateTime())
        ;
    }

    public function getAppTokenByAppNameAndScope($appName, $scope)
    {
        return $this->getActiveQB()
            ->andWhere('a.appName = :app_name')
            ->setParameter('app_name', $appName)
            ->andWhere('a.scope = :scope')
            ->setParameter('scope', $scope)
            ->getQuery()
            ->execute()
        ;
    }
}
