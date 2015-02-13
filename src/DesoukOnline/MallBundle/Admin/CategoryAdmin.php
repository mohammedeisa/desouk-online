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
		///////////////////////////// Add Image preview /////////////////////////////////////
        // get the current Image instance
        $cat = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);
        $fileFieldOptions['label'] = 'Image';
        if ($cat && ($webPath = $cat->getWebPath()) && is_file($cat->getAbsolutePath())) {

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img width="100" height="100" src="' . $webPath . '" class="admin-preview" />';
        }
        /////////////////////////////////////////////////////////////////////////////////////
        $formMapper
            ->add('title')
            ->add('description', 'ckeditor')
            ->add('file', 'file', $fileFieldOptions)
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
	
	public function prePersist($cat)
    {
        $this->renameFile($cat);
    }

    public function preUpdate($cat)
    {
        $this->renameFile($cat);
    }

    public function renameFile($cat)
    {
        if (null !== $cat->getFile()) {
            // do whatever you want to generate a unique name
            $cat->upload();
        }
    }



}