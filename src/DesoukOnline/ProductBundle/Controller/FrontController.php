<?php

namespace DesoukOnline\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;

class FrontController extends Controller
{


    private $repo;

    /**
     * @Route("/categories", name="products")
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT a FROM DesoukOnlineProductBundle:Category a";
        $categories = $em->createQuery($dql);

//        $categories = $this->getDoctrine()
//            ->getRepository('DesoukOnlineProductBundle:Category');
        $this->homeUrl = $this->get('router')->getContext()->getBaseUrl();
        $this->repoitory = $this->getDoctrine()->getRepository('DesoukOnlineProductBundle:Category');

        $htmlTree = $this->getProductsMenu();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $categories,
            $this->get('request')->query->get('page', 1) /*page number*/,
            9/*limit per page*/
        );

        $config=$this->get('request')->getSession()->get('tabs_config');
        // parameters to template
        return $this->render('DesoukOnlineProductBundle:Front:index.html.twig', array('categories' => $pagination, 'menu' => $htmlTree, 'config'=>$config));
//
    }

    /**
     * @Route("/products/category/{slug}", name="product_category")
     */
    public function productCategoryAction($slug)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $category = $this->getDoctrine()
            ->getRepository('DesoukOnlineProductBundle:Category')->findOneBy(array('slug' => $slug));

        $dql = "SELECT c FROM DesoukOnlineProductBundle:Category c
         WHERE c.parent=:category";

        $categories = $em->createQuery($dql)->setParameter('category', $category->getId())->getResult();


        $dql = "SELECT psc FROM DesoukOnlineProductBundle:ProductHasCategory psc
         WHERE  psc.id_category = :category";

        $products= $em->createQuery($dql)->setParameter('category', $category->getId())->getResult();

        $query=array_merge($categories,$products);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1) /*page number*/,
            9/*limit per page*/
        );

        $config=$this->get('request')->getSession()->get('tabs_config');
        $language=$this->get('request')->getSession()->get('language');

        if($category->getIsElevators()&&$category->getIsArabic()&&$language=='ar')
            return $this->render(
                'DesoukOnlineProductBundle:Front:elevators.html.twig',
                array('category' => $pagination,'current_category' => $category, 'config'=>$config,'language'=>$language));

        return $this->render(
            'DesoukOnlineProductBundle:Front:category.html.twig',
            array('category' => $pagination,'current_category' => $category, 'config'=>$config,'language'=>$language));
    }

    /**
     * @Route("/products/{slug}", name="product_show")
     */
    public function productShowAction($slug)
    {
        $product = $this->getDoctrine()
            ->getRepository('DesoukOnlineProductBundle:Product')->findOneBy(array('slug' => $slug));

        $config=$this->get('request')->getSession()->get('tabs_config');
        return $this->render(
            'DesoukOnlineProductBundle:Front:product.html.twig',
            array('product' => $product, 'config'=>$config));
    }


    function display_children($resltSet, $level = 0, $repo)
    {
        $menu = "<ul>";
        foreach ($resltSet as $article) {
            if (count($repo->children($article)) > 0) {
                $menu = $menu . "<li><a href='" . $article->getName() . "'>" . $article->getName() . "</a>";
                $this->display_children($article, $level + 1, $repo);
                $menu = $menu . "</li>";
            } elseif (count($repo->children($article)) == 0) {
                $menu = $menu . "<li><a href='" . $article->getName() . "'>" . $article->getName() . "</a></li>";
            } else;
        }
        $menu = $menu . "</ul>";
        return $menu;
    }

    private function getProductsMenu()
    {
        $options = array(
            'decorate' => true,
            'rootOpen' => '<ul class="side-menu middle-font-size">',
            'rootClose' => '</ul>',
            'childOpen' => '<li>',
            'childClose' => function ($node) {
                    $item = '';
//                    $id = $node['id'];
//                    $category = $this->getDoctrine()
//                        ->getRepository('DesoukOnlineProductBundle:Category')->findOneBy(array('id' => $id));
//                    foreach ($category->getCategoryProduct() as $categoryProduct) {
//                        $item =$item. '<li><a>' . $categoryProduct->getIdProduct()->getName() . '</a></li>';
//                    }
                    $item = $item . '</li>';
                    return $item;
                },
            'nodeDecorator' => function ($node) {
                    return '<a href="' . $this->homeUrl . '/products/category/' . $node['slug'] . '">' . $node['name'] . '</a>';
                }
        );
        $htmlTree = $this->repoitory->childrenHierarchy(
            null, /* starting from root nodes */
            false, /* true: load all children, false: only direct */
            $options
        );
        return $htmlTree;
    }

    /**
     * @Route("/change_language/{slug}/{language}", name="change_language" )
     */
    public function changeLanguageAction(){
        $slug= $this->get('request')->get('slug');
        $language= $this->get('request')->get('language');
        $this->get('request')->getSession()->set('language',$language);
        return $this->redirect($this->generateUrl('product_category', array('slug'=>$slug)));
    }

}
