<?php

namespace DesoukOnline\ProductBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Admin\Admin;

class ProductHasTagAdmin  extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper
            ->add('id_tag', 'sonata_type_model', array('required' => false))

        ;
    }

}