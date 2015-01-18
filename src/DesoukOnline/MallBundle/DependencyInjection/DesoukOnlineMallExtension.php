<?php

namespace DesoukOnline\MallBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DesoukOnlineMallExtension extends Extension
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

        $groups['sonata.admin.group.desouk_online.mall']=array();
        $mall = $groups['sonata.admin.group.desouk_online.mall'];
        $mall['icon']='<i class="fa fa-play-circle"></i>';
        $mall['label']='Mall';

        $mall['items'][] = 'desouk_online.mall.config';
        $mall['items'][] = 'desouk_online.mall.vendor';
        $mall['items'][] = 'desouk_online.mall.category';
        $mall['items'][] = 'desouk_online.mall.vendor.product.category';
        $mall['items'][] = 'desouk_online.mall.product';
        $mall['items'][] = 'desouk_online.mall.vendor.article';

        $groups['sonata.admin.group.desouk_online.mall'] = $mall;
        $container->setParameter('sonata.admin.configuration.dashboard_groups', $groups);

    }
}
