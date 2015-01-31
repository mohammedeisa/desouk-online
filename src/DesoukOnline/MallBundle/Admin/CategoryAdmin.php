<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DesoukOnline\MallBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class CategoryAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $repository_ = $this->getModelManager()->getEntityManager($this->getClass())->getRepository($this->getClass());
        $repository = $repository_->createQueryBuilder('p')
            ->addOrderBy('p.root', 'ASC')
            ->addOrderBy('p.lft', 'ASC');
        $formMapper
            ->add('title')
            ->add('description', 'ckeditor')
            ->add('image', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'desouk_online_mall_category')))
            ->add('enabled', null, array());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {

        $showMapper
            ->add('title')
            ->add('image')
            ->add('parent')
            ->add('description')
            ->add('enabled')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
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
            ->add('title')
            ->add('enabled', null, array('required' => true, 'data' => True));
    }



}