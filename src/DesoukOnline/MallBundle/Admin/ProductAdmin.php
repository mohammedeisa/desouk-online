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
class ProductAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
    	///////////////////////////// Add Image preview /////////////////////////////////////
    	// get the current Image instance
        $product = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
		$fileFieldOptions['label'] = 'Image';
        if ($product && ($webPath = $product->getWebPath()) && is_file($product->getAbsolutePath())) {

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img width="100" height="100" src="'.$webPath.'" class="admin-preview" />';
        }
    	/////////////////////////////////////////////////////////////////////////////////////
        $formMapper
            ->add('name')
            ->add('description', 'ckeditor')
            ->add('code')
            ->add('price')
            ->add('vendorProductCategory')
            ->add('isInHome', null, array())
            ->add('enabled', null, array())
			->add('file', 'file', $fileFieldOptions)
			->add('images', 'sonata_type_collection',
                array(
                    'required' => false,
                    'by_reference' => false
                ),
                array(
                'edit' => 'inline',
                'inline' => 'table',
                'allow_delete' =>true,

            ))
			;
    }


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
            ->add('isInHome', null, array('editable'=>true))
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

	public function getFormTheme()
	{
	    return array_merge(
	        parent::getFormTheme(),
	        array('DesoukOnlineMallBundle:Images:productImages.html.twig')
	    );
	}

	 public function prePersist($product) {
	    $this->renameFile($product);
		$this->manageEmbeddedImageAdmins($product);
	 }
	
	 public function preUpdate($product) {
	    $this->renameFile($product);
		$this->manageEmbeddedImageAdmins($product);
	 }
	
	 public function renameFile($product) {
	    if (null !== $product->getFile()) {
	        // do whatever you want to generate a unique name
	        $product->upload();
	        // $filename = sha1(uniqid(mt_rand(), true));
	        // $realestate->setPath($filename.'.'.$realestate->getFile()->guessExtension());
	    }
	 }
	 private function manageEmbeddedImageAdmins($product) {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldName == 'images') {
                /** @var Image $image */
                $images = $product->getImages();
				foreach ($images as $image) {
					if ($image->getFile()) {
                        // update the Image to trigger file management
                        $image->upload();
                    } 
				}
            }
        }
    }
	 
}