<?php

namespace Rz\ClassificationBundle\Entity;

use Sonata\ClassificationBundle\Entity\ContextManager as BaseContextManager;

class ContextManager extends BaseContextManager
{
    /**
     * @param array $contexts
     * @param bool $enabled
     *
     * @return Array
     */
    public function getDefunctContext(array $contexts, $enabled = true)
    {
        $query = $this->getObjectManager()->createQueryBuilder()
            ->select('c')
            ->from( $this->getClass(), 'c')
            ->where('c.id NOT IN (:context)')
            ->andWhere('c.enabled = :enabled')
            ->setParameter('context', $contexts)
            ->setParameter('enabled', $enabled)
            ->getQuery()
            ->useResultCache(true, 3600);

        $defunctContexts = $query->getResult();

        return $defunctContexts;
    }
}
