<?php

namespace DesoukOnline\ArticleBundle\Admin;

use Sonata\MediaBundle\Admin\GalleryHasMediaAdmin as BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Admin\Admin;

class ArticleHasCategoryAdmin  extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
            ->add('id_category', 'sonata_type_model', array('required' => false,))
        ;
    }

}