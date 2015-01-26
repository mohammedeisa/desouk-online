<?php

namespace DesoukOnline\MallBundle\Controller;

use DesoukOnline\MallBundle\Entity\Article;
use DesoukOnline\MallBundle\Entity\MallConfig;
use DesoukOnline\MallBundle\Entity\Product;
use DesoukOnline\MallBundle\Entity\Vendor;
use DesoukOnline\MallBundle\Entity\VendorProductCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DesoukOnline\MallBundle\Entity\Category;

class FrontController extends Controller
{
    /**
     * @Route("/mall", name ="mall")
     * @Template("DesoukOnlineMallBundle:Front:Mall/index.html.twig")
     */
    public function indexAction()
    {
        $config = null;
        $query = $this->getDoctrine()->getManager()
            ->createQuery('SELECT p FROM ' . get_class(new MallConfig()) . ' p ');
        try {
            $config = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        $categoriesResult = $this->getDoctrine()->getManager()->getRepository(get_class(new Category()))->findAll();

        $paginator = $this->get('knp_paginator');
        $categories = $paginator->paginate(
            $categoriesResult,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return array('categories' => $categories, 'config' => $config);
    }

    /**
     * @Route("/mall/category/{slug}", name ="mall_category")
     * @Template("DesoukOnlineMallBundle:Front:Mall/category.html.twig")
     */
    public function categoryAction()
    {
        $category = $this->getDoctrine()->getManager()->getRepository(get_class(new Category()))->findOneBy(array('slug' => $this->get('request')->get('slug')));

        $paginator = $this->get('knp_paginator');
        $categoryVendors = $paginator->paginate(
            $category->getVendors(),
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );
        return array('category' => $category, 'category_vendors' => $categoryVendors);

    }

    /**
     * @Route("/mall/vendor/{slug}", name ="vendor")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor.html.twig")
     */
    public function vendorAction()
    {
        $vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('vendor' => $vendor);
    }

    /**
     * @Route("/mall/vendor/product_category/{slug}", name ="vendor_product_category")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor_product_category.html.twig")
     */
    public function vendorProductCategoryAction()
    {
        $vendorProductCategory = $this->getDoctrine()->getManager()->getRepository(get_class(new VendorProductCategory()))->findOneBy(array('slug' => $this->get('request')->get('slug')));

        $paginator = $this->get('knp_paginator');
        $categoryProducts = $paginator->paginate(
            $vendorProductCategory->getProducts(),
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return array('vendor_product_category' => $vendorProductCategory, 'category_products' => $categoryProducts);
    }


    /**
     * @Route("/mall/vendor/product/{slug}", name ="vendor_product")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor_product.html.twig")
     */
    public function vendorProductAction()
    {
        $product = $this->getDoctrine()->getManager()->getRepository(get_class(new Product()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('product' => $product);
    }


    /**
     * @Route("/mall/vendor/article/{slug}", name ="vendor_article")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor_article.html.twig")
     */
    public function vendorArticleAction()
    {
        $article = $this->getDoctrine()->getManager()->getRepository(get_class(new Article()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('article' => $article);
    }

    /**
     * @Route("/vendor_menu/{vendor}" , name ="vendor_menu")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor_menu.html.twig")
     */
    public function vendorMenuAction()
    {
        $vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('vendor' => $vendor);
    }
}
