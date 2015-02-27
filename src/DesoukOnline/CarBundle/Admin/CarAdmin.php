<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DesoukOnline\CarBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class CarAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
    	///////////////////////////// Add Image preview /////////////////////////////////////
    	// get the current Image instance
        $car = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
		$fileFieldOptions['label'] = 'Image';
        if ($car && ($webPath = $car->getWebPath()) && is_file($car->getAbsolutePath())) {

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img width="100" height="100" src="'.$webPath.'" class="admin-preview" />';
        }
    	/////////////////////////////////////////////////////////////////////////////////////
        $formMapper
            ->add('title')
			->add('type', 'choice', 
            	array('choices' => 
            		array(
            			'أجرة' => 'أجرة', 
            			'ملاكى' => 'ملاكى',
            			'نقل' => 'نقل', 
					)
				)
			)
			->add('mark')
			->add('summary')
            ->add('description', 'ckeditor')
            ->add('price')
            ->add('gallery', 'sonata_type_model_list', array(), array('link_parameters' => array('context' => 'default')))
            ->add('enabled', null, array('required' => true, 'data' => True))
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

            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('description')
            ->add('enabled')
            ->add('price')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title')
//            ->add('price')
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
            ->add('price')
            ->add('enabled', null, array('required' => true, 'data' => True));
    }
	
	public function getFormTheme()
	{
	    return array_merge(
	        parent::getFormTheme(),
	        array('DesoukOnlineCarBundle:Images:images.html.twig')
	    );
	}

	public function prePersist($car) {
	    $this->renameFile($car);
		$this->manageEmbeddedImageAdmins($car);
	 }
	
	 public function preUpdate($car) {
	    $this->renameFile($car);
		$this->manageEmbeddedImageAdmins($car);
	 }
	
	 public function renameFile($car) {
	    if (null !== $car->getFile()) {
	        // do whatever you want to generate a unique name
	        $car->upload();
	        // $filename = sha1(uniqid(mt_rand(), true));
	        // $realestate->setPath($filename.'.'.$realestate->getFile()->guessExtension());
	    }
	 }
	 private function manageEmbeddedImageAdmins($car) {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldName == 'images') {
                /** @var Image $image */
                $images = $car->getImages();
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