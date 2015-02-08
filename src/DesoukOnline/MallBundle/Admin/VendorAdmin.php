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
class VendorAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        ///////////////////////////// Add Image preview /////////////////////////////////////
        // get the current Image instance
        $realestate = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
        $fileFieldOptions['label'] = 'Logo';
        if ($realestate && ($webPath = $realestate->getWebPath()) && is_file($realestate->getAbsolutePath())) {

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img width="100" height="100" src="' . $webPath . '" class="admin-preview" />';
        }
        /////////////////////////////////////////////////////////////////////////////////////
        $date = new \DateTime();
        $date->modify('+5 year');
        $formMapper
            ->add('user')
            ->add('title')
            ->add('description', 'ckeditor')
            ->add('category')
            ->add('telephone')
            ->add('facebook')
            ->add('email')
            ->add('expiredAt', 'sonata_type_date_picker', array(
                'dp_min_date' => 'now',
                'dp_max_date' => $date->format('c'),
                'required' => false
            ))
            ->add('file', 'file', $fileFieldOptions)
            ->add('images', 'sonata_type_collection',
                array(
                    'required' => false,
                    'by_reference' => false,
                    'label' => "Banners"
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'allow_delete' => true,

                ))
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
            ->add('telephone')
            ->add('facebook')
            ->add('email')
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

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('DesoukOnlineMallBundle:Images:images.html.twig')
        );
    }

    public function prePersist($vendor)
    {
        $this->renameFile($vendor);
        $this->manageEmbeddedImageAdmins($vendor);
    }

    public function preUpdate($vendor)
    {
        $this->renameFile($vendor);
        $this->manageEmbeddedImageAdmins($vendor);
    }

    public function renameFile($vendor)
    {
        if (null !== $vendor->getFile()) {
            // do whatever you want to generate a unique name
            $vendor->upload();
            // $filename = sha1(uniqid(mt_rand(), true));
            // $realestate->setPath($filename.'.'.$realestate->getFile()->guessExtension());
        }
    }

    private function manageEmbeddedImageAdmins($vendor)
    {
        // Cycle through each field
        foreach ($this->getFormFieldDescriptions() as $fieldName => $fieldDescription) {
            // detect embedded Admins that manage Images
            if ($fieldName == 'images') {
                /** @var Image $image */
                $images = $vendor->getImages();
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