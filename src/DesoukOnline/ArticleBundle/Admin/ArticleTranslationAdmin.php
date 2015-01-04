<?php
/**
 * Created by PhpStorm.
 * User: 780
 * Date: 5/12/14
 * Time: 12:13 PM
 */

namespace DesoukOnline\ArticleBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ArticleTranslationAdmin extends Admin {

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('field')
            ->add('content')
            ;

    }



} 