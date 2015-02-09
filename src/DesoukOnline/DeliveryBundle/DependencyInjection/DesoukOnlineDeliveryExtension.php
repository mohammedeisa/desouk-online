<?php

namespace DesoukOnline\DeliveryBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DesoukOnlineDeliveryExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('config.yml');

        $groups = $container->getParameter('sonata.admin.configuration.dashboard_groups');

        $delivery = array();
        $delivery['icon'] = '<i class="fa fa-play-circle"></i>';;
        $delivery['label'] = 'Delivery';

        $delivery['items'][] = 'desouk_online.delivery';
        $delivery['items'][] = 'desouk_online.delivery.menu';

        $groups['sonata.admin.group.desouk_online.delivery'] = $delivery;
        $container->setParameter('sonata.admin.configuration.dashboard_groups', $groups);


    }
}
