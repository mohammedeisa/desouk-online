<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DesoukOnline\WebDevelopmentBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class WebDevelopmentAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Web development',array('tab'=>true))
            ->add('webDevelopmentTitle')
            ->add('webDevelopmentDescription', 'ckeditor')
            ->add('webDevelopmentBanner', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'desouk_online_web_development_banner')))

            ->end()
            ->end()
            ->with('Hosting',array('tab'=>true))
            ->add('hostingTitle')
            ->add('hostingDescription', 'ckeditor')
            ->add('hostingBanner', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'desouk_online_hosting_banner')))

            ->end()
            ->end()
            ->with('General',array('tab'=>true))
            ->add('image', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'desouk_online_web_development')))
            ->add('banners', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'desouk_online_web_development')))
            ->end()
            ->end()
            ->add('metaTitle')
            ->add('metaDescription')
        ;
    }


    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('webDevelopmentTitle')
            ->add('hostingTitle');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('webDevelopmentTitle')
            ->add('hostingTitle')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('webDevelopmentTitle')
            ->add('hostingTitle');
    }


}