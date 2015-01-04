<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DesoukOnline\ArticleBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class ArticleAdmin extends Admin
{

//    public function __construct()
//    {
//        $this->translations = new ArrayCollection();
//    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('enabled')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }


    public function getTranslations()
    {
        return $this->translations;
    }
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $repository_ = $this->getModelManager()->getEntityManager($this->getClass())->getRepository($this->getClass());
        $repository = $repository_->createQueryBuilder('p')
            ->addOrderBy('p.root', 'ASC')
            ->addOrderBy('p.lft', 'ASC');



        $formMapper
            ->add('name')
            ->add('description', 'ckeditor')
            ->add('parent', 'sonata_type_model', array('required' => false, 'query' => $repository), array('edit' => 'standard'))
            ->add('image', 'sonata_type_model_list', array(), array( 'link_parameters' => array('context' => 'desouk_online_article')))
            ->add('banner', 'sonata_type_model_list', array(), array( 'link_parameters' => array('context' => 'desouk_online_banner')))
            ->add('enabled', null, array('required' => true, 'data' => True))
            ->add('isIntro', null, array('required' => false))
            ->add('isFeaturedContent', null, array('required' => false))
            ->add('isHistory', null, array('required' => false))
            ->add('isAboutRoot', null, array('required' => false))
            ->add('isAbout', null, array('required' => false))
            ->add('isVision', null, array('required' => false))
            ->add('isPhilosophy', null, array('required' => false))
            ->add('isLifeAtUltimatrue', null, array('required' => false))
//            ->add('translations', 'collection', array(
//                'type'         => new TranslationEntityType('DesoukOnline\ArticleBundle\Entity\ArticleTranslations'),
//                'allow_add'    => true,
//            ))
        ;
    }


    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $repository = $this->getModelManager()->getEntityManager($this->getClass())->getRepository($this->getClass());
        $repository = $repository->createQueryBuilder('p')
            ->addOrderBy('p.root', 'ASC')
            ->addOrderBy('p.lft', 'ASC');
        $datagridMapper
            ->add('parent', 'doctrine_orm_callback', array(
                    'callback' => array($this, 'getAllChildArticles'),
                    'field_type' => 'checkbox'
                ), 'choice', array('choices' => $this->getAllArticles())
            )
            ->add('name')
            ->add('enabled');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('description')
            ->add('enabled');
    }

    public function getAllChildArticles($queryBuilder, $alias, $field, $value)
    {

        if (!$value['value']) {
//            $queryBuilder->addOrderBy($alias . '.position', 'ASC');
            $queryBuilder->addOrderBy($alias . '.root', 'ASC');
            $queryBuilder->addOrderBy($alias . '.lft', 'ASC');
            return true;
        }

        $selectedCat = $value['value'];
        $repository = $this->getModelManager()->getEntityManager("DesoukOnline\ArticleBundle\Entity\Article")
            ->getRepository("DesoukOnline\ArticleBundle\Entity\Article");
        $qb = $repository->createQueryBuilder('c');
        $qb->where('c.parent=:parent');
        $qb->setParameter('parent', $selectedCat);
        $articles = $qb->getQuery()->getResult();
        $childIds = array();

        foreach ($articles as $cat) {
            array_push($childIds, $cat->getId());
        }

        $parentAndChildIds = $childIds;
        array_push($parentAndChildIds, $selectedCat);
        $queryBuilder->andWhere($alias . '.id IN(:cat)');
        $queryBuilder->setParameter('cat', $parentAndChildIds);
        $queryBuilder->addOrderBy($alias . '.id', 'ASC');
        return true;
    }


    public function getAllArticles()
    {

        $repository = $this->getModelManager()->getEntityManager("DesoukOnline\ArticleBundle\Entity\Article")
            ->getRepository("DesoukOnline\ArticleBundle\Entity\Article");
        $qb = $repository->createQueryBuilder('c')
            ->addOrderBy('c.root', 'ASC')
            ->addOrderBy('c.lft', 'ASC');

        $results = $qb->getQuery()->getResult();
        $choices = array();
        foreach ($results as $result) {
            $choices[$result->getId()] = $result->__toString();
        }
        return $choices;

    }

    public function preUpdate($article)
    {

//        $translations = $article->getTranslations();
//        foreach($translations as $trans){
//
//            $name = $trans->getName();
//            var_dump($name);
//        }
//        exit;

    }

    public function prePersist($cat)
    {
        if ($cat->getParent() == null) {

            $repository = $this->getModelManager()->getEntityManager("DesoukOnline\ArticleBundle\Entity\Article")
                ->getRepository("DesoukOnline\ArticleBundle\Entity\Article");
            $qb = $repository->createQueryBuilder('p');
            $qb->addSelect('MAX(p.position)as position')->orderBy('p.position', 'DESC');
            $result = $qb->getQuery()->getResult();

            if ($result != null) {
                $result = $result[0];
                $position = $result['position'];
                $position++;
            } else {
                $position = 1;
            }

            $cat->setPosition($position);

        } else {
            $position = $cat->getparent()->getPosition();

            $cat->setPosition($position);
        }

    }

}