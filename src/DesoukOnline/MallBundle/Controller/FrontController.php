<?php

namespace DesoukOnline\MallBundle\Controller;

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
        $categories = $this->getDoctrine()->getManager()->getRepository(get_class(new Category()))->findAll();
        return array('categories' => $categories);
    }

    /**
     * @Route("/mall/category/{slug}", name ="mall_category")
     * @Template("DesoukOnlineMallBundle:Front:Mall/category.html.twig")
     */
    public function categoryAction()
    {
        $category = $this->getDoctrine()->getManager()->getRepository(get_class(new Category()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('category' => $category);

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
        return array('vendor_product_category' => $vendorProductCategory);
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

}
