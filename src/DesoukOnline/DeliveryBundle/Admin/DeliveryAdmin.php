<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DesoukOnline\DeliveryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class DeliveryAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
    	///////////////////////////// Add Image preview /////////////////////////////////////
        // get the current Image instance
        $delivery = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
        $fileFieldOptions['label'] = 'Logo';
        if ($delivery && ($webPath = $delivery->getWebPath()) && is_file($delivery->getAbsolutePath())) {

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img width="100" height="100" src="' . $webPath . '" class="admin-preview" />';
        }
        /////////////////////////////////////////////////////////////////////////////////////
        $date = new \DateTime();
		$date_from = $date;
        $date_to = $date->modify('+5 year');
        $formMapper
            ->add('title')
			->add('user')
            ->add('description', 'ckeditor')
            ->add('telephone')
            ->add('facebook')
            ->add('email')
            ->add('expiredAt', 'sonata_type_date_picker', array(
                'dp_min_date' => '2015-01-01',
                'dp_max_date' => '2016-01-01',
                'required' => false
            ))
            ->add('file', 'file', $fileFieldOptions)
            ->add('enabled', null, array('required' => true, 'data' => True));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('description')
            ->add('contacts')
            ->add('logo')
            ->add('enabled');
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
            ->add('enabled');
    }
	
	public function prePersist($delivery)
    {
        $this->renameFile($delivery);
    }

    public function preUpdate($delivery)
    {
        $this->renameFile($delivery);
    }

    public function renameFile($delivery)
    {
        if (null !== $delivery->getFile()) {
            // do whatever you want to generate a unique name
            $delivery->upload();
            // $filename = sha1(uniqid(mt_rand(), true));
            // $realestate->setPath($filename.'.'.$realestate->getFile()->guessExtension());
        }
    }

}