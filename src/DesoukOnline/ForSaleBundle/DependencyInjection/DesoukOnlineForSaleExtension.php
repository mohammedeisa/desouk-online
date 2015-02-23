<?php

namespace DesoukOnline\ForSaleBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DesoukOnlineForSaleExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $groups = $container->getParameter('sonata.admin.configuration.dashboard_groups');

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('config.yml');

        $groups['sonata.admin.group.desouk_online.for_sale']=array();
        $forSale = $groups['sonata.admin.group.desouk_online.for_sale'];
        $forSale['icon']='<i class="fa fa-play-circle"></i>';
        $forSale['label']='For Sale';

        $forSale['items'][] = 'desouk_online.for_sale.config';
        $forSale['items'][] = 'desouk_online.for_sale_category';
        $forSale['items'][] = 'desouk_online.for_sale';

        $groups['sonata.admin.group.desouk_online.for_sale'] = $forSale;
        $container->setParameter('sonata.admin.configuration.dashboard_groups', $groups);
        
    }
}
