<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DesoukOnline\ProductBundle\Admin;

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

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $repository = $this->getModelManager()->getEntityManager($this->getClass())->getRepository($this->getClass());
        $repository = $repository->createQueryBuilder('p')
            ->addOrderBy('p.root','ASC')
            ->addOrderBy('p.lft', 'ASC');
        $datagridMapper
            ->add('parent','doctrine_orm_callback', array(
                    'callback'   => array($this, 'getAllChildCategories'),
                    'field_type' => 'checkbox'
                )
                ,
                'choice',
                array('choices' => $this->getAllCategories())
            )
            ->add('name')
        ;
    }
    public function getAllCategories(){

        $repository = $this->getModelManager()->getEntityManager("DesoukOnline\ProductBundle\Entity\Category")
            ->getRepository("DesoukOnline\ProductBundle\Entity\Category");
        $qb = $repository->createQueryBuilder('c')
            ->addOrderBy('c.root','ASC')
            ->addOrderBy('c.lft', 'ASC');

        $results = $qb->getQuery()->getResult();
        $choices = array();
        foreach ($results as $result){
            $choices[$result->getId()]=$result->__toString();
        }
        return $choices;

    }

    public function getAllChildCategories($queryBuilder, $alias, $field, $value)
    {
//        var_dump($value) ;
//        exit;
        if (!$value['value']) {
            $queryBuilder->addOrderBy($alias.'.position','ASC');
            $queryBuilder->addOrderBy($alias.'.root','ASC');
            $queryBuilder->addOrderBy($alias.'.lft', 'ASC');
//            $queryBuilder->add("lvl".'title');
            return true;
        }

        $selectedCat = $value['value'];
//        $temp =  $repository = $this->getModelManager()->getEntityManager("DesoukOnline\ItemBundle\Entity\Category")
//        ->getRepository("DesoukOnline\ItemBundle\Entity\Category")->find($selectedCat);
        $repository = $this->getModelManager()->getEntityManager("DesoukOnline\ProductBundle\Entity\Category")
            ->getRepository("DesoukOnline\ProductBundle\Entity\Category");
        $qb = $repository->createQueryBuilder('c');
        $qb->where('c.parent=:parent');
        $qb->setParameter('parent', $selectedCat);
        $categories = $qb->getQuery()->getResult();
        $childIds = array();

        foreach($categories as $cat){
            array_push($childIds, $cat->getId());
        }

        $parentAndChildIds=$childIds;
        array_push($parentAndChildIds, $selectedCat);
        //$parentCat = $result[0]->getId();
        //$queryBuilder->leftJoin(sprintf('%s.item', $alias), 'c');

        $queryBuilder->andWhere($alias.'.id IN(:cat)');
        $queryBuilder->setParameter('cat', $parentAndChildIds);
        $queryBuilder ->addOrderBy($alias.'.id', 'ASC');
        // $queryBuilder->leftJoin(sprintf('%s.comments', $alias), 'c');
        // $queryBuilder->andWhere('c.status = :status');
        //  $queryBuilder->setParameter('status', Comment::STATUS_MODERATE);

        return true;
    }


    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
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
            ->addIdentifier('Name','', array('template' => 'DesoukOnlineProductBundle:Admin:names_hierarchy_field.html.twig'))
            ->add('enabled')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'Sort' => array ('template' => 'DesoukOnlineProductBundle:Admin:sort.html.twig'),
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */


    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {  $repository_ = $this->getModelManager()->getEntityManager($this->getClass())->getRepository($this->getClass());
        $repository = $repository_->createQueryBuilder('p')
            ->addOrderBy('p.root','ASC')
            ->addOrderBy('p.lft', 'ASC');
        $formMapper
            ->with('English')
            ->add('name')
            ->add('description','ckeditor')
            ->end()
            ->with('Arabic')
            ->add('nameAr')
            ->add('descriptionAr','ckeditor')
            ->end()
            ->add('image', 'sonata_type_model_list', array(), array( 'link_parameters' => array('context' => 'desouk_online_categoy')))
            ->add('banner', 'sonata_type_model_list', array(), array( 'link_parameters' => array('context' => 'desouk_online_banner')))
            ->add('parent', 'sonata_type_model', array('required' => false, 'query' => $repository), array('edit' => 'standard'))
            ->add('enabled' ,null, array('required' => true, 'data' => True))
            ->add('isElevators' ,null, array('required' => false))
            ->add('isArabic' ,null, array('required' => false))
        ;
    }


    public function prePersist($cat) {


        if($cat->getParent()==null){

            $repository = $this->getModelManager()->getEntityManager("DesoukOnline\ProductBundle\Entity\Category")
                ->getRepository("DesoukOnline\ProductBundle\Entity\Category");
            $qb = $repository->createQueryBuilder('p');
            $qb->addSelect('MAX(p.position)as position')->orderBy('p.position', 'DESC');
            $result = $qb->getQuery()->getResult();

            if($result != null){
                $result = $result[0];
                $position = $result['position'];
                $position++;
            }else{$position = 1;}

            $cat->setPosition($position);


        }else {
            $position = $cat->getparent()->getPosition();

            $cat->setPosition($position);
        }


    }








}