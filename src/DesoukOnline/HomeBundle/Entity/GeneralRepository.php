<?php

namespace DesoukOnline\HomeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GeneralRepository extends EntityRepository
{
    public function getGeneralConfigurationsAndBundleConfigurations($className)
    {
        $generalConfig = $bundleConfig = null;

        $query = $this->getEntityManager()
            ->createQuery('SELECT p FROM ' . $className . ' p ');
        try {
            $bundleConfig = $query->getOneOrNullResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            $bundleConfig = null;
        }
        $query2 = $this->getEntityManager()
            ->createQuery('SELECT p FROM ' . get_class(new General()) . ' p ');
        try {
            $generalConfig = $query2->getOneOrNullResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            $generalConfig = null;
        }
        return array(
            'generalConfig' => $generalConfig,
            'bundleConfig' => $bundleConfig
        );
    }
}
