<?php

namespace DesoukOnline\MallBundle\Controller;

use DesoukOnline\MallBundle\Entity\Article;
use DesoukOnline\MallBundle\Entity\MallConfig;
use DesoukOnline\MallBundle\Entity\Product;
use DesoukOnline\MallBundle\Entity\Vendor;
use DesoukOnline\MallBundle\Entity\VendorImage;
use DesoukOnline\MallBundle\Entity\ProductImage;
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
        $config=null;
        $query = $this->getDoctrine()->getManager()
            ->createQuery('SELECT p FROM ' . get_class(new MallConfig()) . ' p ');
        try {
            $config = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        $categories = $this->getDoctrine()->getManager()->getRepository(get_class(new Category()))->findAll();
        return array('categories' => $categories, 'config' => $config);
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
	
	///////////////////////////// Backend Vendor Delete Image //////////////////////////////
	/**
     * @Route("/admin/vendor/deleteImage/{vendor}/{image_id}" , name ="vendor_deleteImge")
     */
    public function deleteVendorImageAction($vendor,$image_id)
    {
    	$url = $this->generateUrl(
            'admin_desoukonline_mall_vendor_edit',
            array('id' => $vendor)
        );
		$image = $this->getDoctrine()->getManager()->getRepository(get_class(new VendorImage()))->findOneBy(array('id' => $image_id));
		if (is_file($image->getAbsolutePath())) {
			unlink($image->getAbsolutePath());
		}
		$em = $this->getDoctrine()->getManager();
		$em->remove($image);
		$em->flush();
		
		return $this->redirect($url);
    }
    
    ///////////////////////////// Backend Product Delete Image //////////////////////////////
	/**
     * @Route("/admin/product/deleteImage/{product}/{image_id}" , name ="product_deleteImge")
     */
    public function deleteProductImageAction($product,$image_id)
    {
    	$url = $this->generateUrl(
            'admin_desoukonline_mall_product_edit',
            array('id' => $product)
        );
		$image = $this->getDoctrine()->getManager()->getRepository(get_class(new ProductImage()))->findOneBy(array('id' => $image_id));
		if (is_file($image->getAbsolutePath())) {
			unlink($image->getAbsolutePath());
		}
		$em = $this->getDoctrine()->getManager();
		$em->remove($image);
		$em->flush();
		
		return $this->redirect($url);
    }
}
