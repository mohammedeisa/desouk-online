<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DesoukOnline\ProductBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class ProductAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('code')
            ->add('price')
            ->add('description')
            ->add('enabled');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('code')
            ->add('price')
            ->add('enabled')
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
            ->add('name')
            ->add('enabled')
            ->add('code');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $repository = $this->getModelManager()->getEntityManager("DesoukOnline\ProductBundle\Entity\Category")
            ->getRepository("DesoukOnline\ProductBundle\Entity\Category");
        $qb = $repository->createQueryBuilder('c');

        $formMapper
            ->with('English', array('tab' => true))
            ->add('name')
            ->add('description', 'ckeditor')
            ->end()
            ->end()
            ->with('Arabic', array('tab' => true))
            ->add('nameAr')
            ->add('descriptionAr', 'ckeditor')
            ->end()
            ->end()
            ->with('General', array('tab' => true))
            ->add('code')
            ->add('price')
            ->add('gallery', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'default')))
            ->add('product_category', 'sonata_type_collection', array(
                    'cascade_validation' => true,
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                    'link_parameters' => array('context' => 'default'),
                )
            )
            ->add('enabled', null, array('required' => true, 'data' => True))
            ->add('image', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'desouk_online_product')))
            ->add('banner', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'desouk_online_banner')))
            ->end()
            ->end();
    }

}