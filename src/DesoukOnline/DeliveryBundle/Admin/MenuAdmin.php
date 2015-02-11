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
class MenuAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
    	///////////////////////////// Add Image preview /////////////////////////////////////
        // get the current Image instance
        $menu = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
        $fileFieldOptions['label'] = 'Logo';
        if ($menu && ($webPath = $menu->getWebPath()) && is_file($menu->getAbsolutePath())) {

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img width="100" height="100" src="' . $webPath . '" class="admin-preview" />';
        }
        /////////////////////////////////////////////////////////////////////////////////////
        $formMapper
            ->add('title')
            ->add('description', 'ckeditor')
            ->add('delivery')
			->add('file', 'file', $fileFieldOptions)
            ->add('menuItems', 'sonata_type_collection', array(
                'cascade_validation' => true,
            ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                    'link_parameters' => array('context' => 'default'),
                )
            );
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
            ->add('logo');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
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
            ->add('title');
    }

    public function prePersist($object)
    {
        if ($object->getMenuItems())
            foreach ($object->getMenuItems() as $menuItem) {
                $menuItem->setMenu($object);
            }
		$this->renameFile($object);
		$this->manageEmbeddedImageAdmins($object);
    }

    public function preUpdate($object)
    {
        if ($object->getMenuItems())
            foreach ($object->getMenuItems() as $menuItem) {
                $menuItem->setMenu($object);
            }
		$this->renameFile($object);
		$this->manageEmbeddedImageAdmins($object);
    }
	
	public function getFormTheme()
	{
	    return array_merge(
	        parent::getFormTheme(),
	        array('DesoukOnlineDeliveryBundle:Images:deliveryItems.html.twig')
	    );
	}
	
	public function renameFile($object)
    {
        if (null !== $object->getFile()) {
            $object->upload();
        }
    }
	
	 private function manageEmbeddedImageAdmins($product) {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldName == 'menuItems') {
                /** @var Image $image */
                $menuItems = $product->getMenuItems();
				foreach ($menuItems as $menuItem) {
					if ($menuItem->getFile()) {
                        // update the Image to trigger file management
                        $menuItem->upload();
                    } 
				}
            }
        }
    }

}