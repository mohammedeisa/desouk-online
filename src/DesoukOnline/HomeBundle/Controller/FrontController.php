<?php

namespace DesoukOnline\HomeBundle\Controller;

use DesoukOnline\BannerBundle\Entity\Banner;
use DesoukOnline\CarBundle\Entity\Car;
use DesoukOnline\DeliveryBundle\Entity\Delivery;
use DesoukOnline\ForSaleBundle\Entity\ForSale;
use DesoukOnline\JobsBundle\Entity\Job;
use DesoukOnline\MallBundle\Entity\Product;
use DesoukOnline\RealEstateBundle\Entity\RealEstate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use DesoukOnline\RealEstateBundle\Entity\Area;

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
     * @Route("/userMenu" , name ="userMenu")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/userMenu.html.twig")
     */
    public function userMenuAction()
    {
        $loggedIn_user = $this->get('security.context')->getToken()->getUser();
        return array('user' => $loggedIn_user);
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
        $searchIn = $request->query->get('search_in');
        $em = $this->get('doctrine.orm.entity_manager');
        $results = array();
        $queryBuilder = $em->createQueryBuilder();
        if ($searchIn == 'real_estate' || $searchIn == 'desouk_online') {
            $realEstate = $queryBuilder
                ->select('real_estate')
                ->from(get_class(new RealEstate()), 'real_estate')
                ->innerJoin('real_estate.area', 'area')
                ->where($queryBuilder->expr()->like('real_estate.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('real_estate.description', ':search'))
                ->orWhere($queryBuilder->expr()->like('area.name', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            $results['real_estate'] = $realEstate;
        }
        if ($searchIn == 'for_sale' || $searchIn == 'desouk_online') {

            $forSale = $queryBuilder
                ->select('for_sale')
                ->from(get_class(new ForSale()), 'for_sale')
                ->where($queryBuilder->expr()->like('for_sale.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('for_sale.description', ':search'))
                ->orWhere($queryBuilder->expr()->like('for_sale.summary', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            $results['for_sale'] = $forSale;
        }
        if ($searchIn == 'cars' || $searchIn == 'desouk_online') {
            $cars = $queryBuilder
                ->select('cars')
                ->from(get_class(new Car()), 'cars')
                ->innerJoin('cars.mark', 'mark')
                ->where($queryBuilder->expr()->like('cars.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('cars.type', ':search'))
                ->orWhere($queryBuilder->expr()->like('cars.description', ':search'))
                ->orWhere($queryBuilder->expr()->like('mark.name', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            $results['cars'] = $cars;
        }
        if ($searchIn == 'desouk_mall' || $searchIn == 'desouk_online') {
            $desoukMall = $queryBuilder
                ->select('desouk_mall_products')
                ->from(get_class(new Product()), 'desouk_mall_products')
                ->innerJoin('desouk_mall_products.vendorProductCategory', 'vpc')
                ->innerJoin('vpc.vendor', 'vendor')
                ->where($queryBuilder->expr()->like('desouk_mall_products.name', ':search'))
                ->orWhere($queryBuilder->expr()->like('desouk_mall_products.description', ':search'))
                ->orWhere($queryBuilder->expr()->like('vpc.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('vendor.title', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            $results['desouk_mall'] = $desoukMall;
        }
        if ($searchIn == 'delivery' || $searchIn == 'desouk_online') {
            $delivery = $queryBuilder
                ->select('delivery')
                ->from(get_class(new Delivery()), 'delivery')
                ->where($queryBuilder->expr()->like('delivery.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('delivery.description', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            $results['delivery'] = $delivery;
        }

        if ($searchIn == 'jobs' || $searchIn == 'desouk_online') {
            $delivery = $queryBuilder
                ->select('jobs')
                ->from(get_class(new Job()), 'jobs')
                ->where($queryBuilder->expr()->like('jobs.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('jobs.description', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            $results['jobs'] = $delivery;
        }

        return array('results' => $results, 'search' => $search, 'search_in' => $searchIn);

    }


}
