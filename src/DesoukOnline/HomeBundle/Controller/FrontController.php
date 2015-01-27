<?php

namespace DesoukOnline\HomeBundle\Controller;

use DesoukOnline\BannerBundle\Entity\Banner;
use DesoukOnline\MallBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{

    /**
     * @Route("/", name ="home")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/homepage.html.twig")
     */
    public function homeAction()
    {
    }

    /**
     * @Route("/header" , name ="header")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/header.html.twig")
     */
    public function headerAction()
    {
    }

    /**
     * @Route("/footer" , name ="footer")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/footer.html.twig")
     */
    public function footerAction()
    {
    }

    /**
     * @Route("/banner" , name ="banner")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/banner.html.twig")
     */
    public function bannerAction()
    {
        $banners = $this->getDoctrine()->getManager()->getRepository(get_class(new Banner()))->findAll();
        return array('banners' => $banners);
    }

    /**
     * @Route("/mainComponents" , name ="mainComponents")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/main_components.html.twig")
     */
    public function mainComponentsAction()
    {
    }


    /**
     * @Route("/recent_products" , name ="recent_products")
     * @Template("DesoukOnlineHomeBundle:Front:recent_products.html.twig")
     */
    public function recentProductsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $vendorProducts = $em->createQuery('SELECT a FROM ' . get_class(new Product()) . ' a order by a.updatedAt DESC')->setMaxResults(3)->getResult();
        $propertyForSale = null;
        $propertyForRent = null;
        $forSale = null;
        $cars = null;
        return array(
            'vendor_products' => $vendorProducts,
            'property_for_sale' => $propertyForSale,
            'property_for_rent' => $propertyForRent,
            'for_sale' => $forSale,
            'cars' => $cars


        );
    }

    /**
     * @Route("/search/{search_string}", name="search" , defaults={"search_string" = null})
     * @Template("DesoukOnlineHomeBundle:Front:search.html.twig")
     */
    public function searchAction(Request $request)
    {
        $search = $request->query->get('search_string');
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT p FROM DesoukOnlineMallBundle:Product p where p.name like '%" . $search . "%' or p.description like '%" . $search . "%' ";
        $query = $em->createQuery($dql);
        $searchResults = $query->getResult();
        return array('mall_products' => $searchResults, 'search' => $search);

    }


}
