<?php

namespace DesoukOnline\RealEstateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DesoukOnlineRealEstateExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $groups = $container->getParameter('sonata.admin.configuration.dashboard_groups');

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');

        $groups['sonata.admin.group.desouk_online.real_estate']=array();
        $realEstate = $groups['sonata.admin.group.desouk_online.real_estate'];
        $realEstate['icon']='<i class="fa fa-play-circle"></i>';
        $realEstate['label']='Real Estate';

        $realEstate['items'][] = 'desouk_online.real_estate.config';
        $realEstate['items'][] = 'desouk_online.real_estate.area';
        $realEstate['items'][] = 'desouk_online.real_estate';

        $groups['sonata.admin.group.desouk_online.real_estate'] = $realEstate;
        $container->setParameter('sonata.admin.configuration.dashboard_groups', $groups);
    }
}
