<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DesoukOnline\HomeBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class GeneralAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('tab' => true))
            ->add('generalModulesPreTitle')
            ->add('mallPreTitle')
            ->add('homepageMetaTitle')
            ->add('homepageMetaDescription')
            ->end()
            ->end()
            ->with('Real estates', array('tab' => true))
            ->add('realEstateMiddleOfTitleInIndex')
            ->add('realEstateMiddleOfTitleInFilteredIndex')
            ->add('realEstateMiddleOfTitleInShow')
            ->end()
            ->end()
            ->with('Cars', array('tab' => true))
            ->add('carMiddleOfTitleInIndex')
            ->add('carMiddleOfTitleInFilteredIndex')
            ->add('carMiddleOfTitleInShow')
            ->end()
            ->end()
            ->with('Jobs', array('tab' => true))
            ->add('jobMiddleOfTitleInIndex')
            ->add('jobMiddleOfTitleInFilteredIndex')
            ->add('jobMiddleOfTitleInShow')
            ->end()
            ->end()
            ->with('For Sale', array('tab' => true))
            ->add('forSaleMiddleOfTitleInIndex')
            ->add('forSaleMiddleOfTitleInFilteredIndex')
            ->add('forSaleMiddleOfTitleInShow')
            ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('generalModulesPreTitle')
            ->add('mallPreTitle')
            ->add('realEstateMiddleOfTitleInIndex')
            ->add('realEstateMiddleOfTitleInFilteredIndex')
            ->add('realEstateMiddleOfTitleInShow')
            ->add('carMiddleOfTitleInIndex')
            ->add('carMiddleOfTitleInFilteredIndex')
            ->add('carMiddleOfTitleInShow')
            ->add('jobMiddleOfTitleInIndex')
            ->add('jobMiddleOfTitleInFilteredIndex')
            ->add('jobMiddleOfTitleInShow')
            ->add('forSaleMiddleOfTitleInIndex')
            ->add('forSaleMiddleOfTitleInFilteredIndex')
            ->add('forSaleMiddleOfTitleInShow')
        ;
    }


    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('generalModulesPreTitle')->add('_action', 'actions', array(
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
            ->add('generalModulesPreTitle');
    }


}