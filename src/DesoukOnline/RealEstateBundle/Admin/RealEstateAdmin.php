<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DesoukOnline\RealEstateBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class RealEstateAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('type', 'choice', 
            	array('choices' => 
            		array(
            			'منزل' => 'منزل', 
            			'شقة' => 'شقة',
            			'محل' => 'محل', 
            			'أرض بناء' => 'أرض بناء',
            			'أرض زراعية' => 'أرض زراعية'
					)
				)
			)
            ->add('description', 'ckeditor')
            ->add('purpose', 'choice', 
            	array('choices' => 
            		array(
            			'للبيع' => 'للبيع', 
            			'للإيجار' => 'للإيجار',
					)
				)
			)
            ->add('price')
            ->add('area')
            ->add('gallery', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'default')))
            ->add('enabled', null, array('required' => true, 'data' => True))
			->add('file', 'file', array('required' => false));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('type')
            ->add('description')
            ->add('enabled')
            ->add('purpose')
            ->add('price')
            ->add('area');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
            ->add('type')
            ->add('price')
            ->add('area')
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
            ->add('type')
            ->add('purpose')
            ->add('price')
            ->add('area')
            ->add('enabled', null, array('required' => true, 'data' => True));
    }

	 public function prePersist($realestate) {
	    $this->renameFile($realestate);
	 }
	
	 public function preUpdate($realestate) {
	    $this->renameFile($realestate);
	 }
	
	 public function renameFile($realestate) {
	    if (null !== $realestate->getFile()) {
	        // do whatever you want to generate a unique name
	        $realestate->upload();
	        // $filename = sha1(uniqid(mt_rand(), true));
	        // $realestate->setPath($filename.'.'.$realestate->getFile()->guessExtension());
	    }
	 }
}