<?php

namespace DesoukOnline\HomeBundle\Controller;

use DesoukOnline\BannerBundle\Entity\Banner;
use DesoukOnline\CarBundle\Entity\Car;
use DesoukOnline\CarBundle\Entity\CarConfig;
use DesoukOnline\DeliveryBundle\Entity\Delivery;
use DesoukOnline\ForSaleBundle\Entity\ForSale;
use DesoukOnline\ForSaleBundle\Entity\ForSaleConfig;
use DesoukOnline\HomeBundle\Entity\General;
use DesoukOnline\JobsBundle\Entity\Job;
use DesoukOnline\JobsBundle\Entity\JobsConfig;
use DesoukOnline\MallBundle\Entity\MallConfig;
use DesoukOnline\MallBundle\Entity\Product;
use DesoukOnline\RealEstateBundle\Entity\RealEstate;
use DesoukOnline\RealEstateBundle\Entity\RealEstateConfig;
use DesoukOnline\WebDevelopmentBundle\Entity\WebDevelopment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $config = $this->getDoctrine()->getRepository(get_class(new General()))->getGeneralConfigurationsAndBundleConfigurations(get_class(new General()));
        return array('config'=>$config);
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
        $mallConfig = $realEstateConfig = $carConfig = $forSaleConfig = $jobConfig = $webDevelopmentConfig = null;
        $em = $this->getDoctrine()->getManager();
        $mallConfig = $this->getConfig($em, get_class(new MallConfig()));
        $realEstateConfig = $this->getConfig($em, get_class(new RealEstateConfig()));
        $carConfig = $this->getConfig($em, get_class(new CarConfig()));
        $forSaleConfig = $this->getConfig($em, get_class(new ForSaleConfig()));
        $jobConfig = $this->getConfig($em, get_class(new JobsConfig()));
        $webDevelopmentConfig = $this->getConfig($em, get_class(new WebDevelopment()));
        return array(
            'mall_config' => $mallConfig,
            'real_estate_config' => $realEstateConfig,
            'car_config' => $carConfig,
            'for_sale_config' => $forSaleConfig,
            'job_config' => $jobConfig,
            'web_development_config' => $webDevelopmentConfig
        );
    }


    /**
     * @Route("/recent_products" , name ="recent_products")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/recent_products.html.twig")
     */
    public function recentProductsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $realEstate = $em->createQuery('SELECT a FROM ' . get_class(new RealEstate()) . ' a order by a.updatedAt DESC')->setMaxResults(4)->getResult();
        $forSale = $em->createQuery('SELECT a FROM ' . get_class(new ForSale()) . ' a order by a.updatedAt DESC')->setMaxResults(4)->getResult();
        $cars = $em->createQuery('SELECT a FROM ' . get_class(new Car()) . ' a order by a.updatedAt DESC')->setMaxResults(4)->getResult();
        $desoukMall = $em->createQuery('SELECT a FROM ' . get_class(new Product()) . ' a order by a.updatedAt DESC')->setMaxResults(4)->getResult();
//        $delivery = $em->createQuery('SELECT a FROM ' . get_class(new Delivery()) . ' a order by a.updatedAt DESC')->setMaxResults(4)->getResult();

        return array(
            'real_estate' => $realEstate,
            'for_sale' => $forSale,
            'cars' => $cars,
            'desouk_mall' => $desoukMall,
//            'delivery' => $delivery
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
        if ($searchIn == 'real_estate' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
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
        if ($searchIn == 'for_sale' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
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
        if ($searchIn == 'cars' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
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
        if ($searchIn == 'desouk_mall' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
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

        if ($searchIn == 'jobs' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
            $jobs = $queryBuilder
                ->select('jobs')
                ->from(get_class(new Job()), 'jobs')
                ->where($queryBuilder->expr()->like('jobs.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('jobs.description', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            $results['jobs'] = $jobs;
        }
        return array('results' => $results, 'search' => $search, 'search_in' => $searchIn);

    }
    ///////////////////////////// FrontEnd Vendor Delete article //////////////////////////////
    /**
     * @Route("/user_login" , name ="user_login")
     * @Template("DesoukOnlineHomeBundle:Front:login.html.twig")
     */
    public function loginAction()
    {

    }

    function getConfig($em, $entity)
    {
        $query = $em
            ->createQuery('SELECT p FROM ' . $entity . ' p ');
        try {
            $config = $query->getOneOrNullResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        return $config;
    }

    /**
     * @Route("/search_suggestion", name="search_suggestion" , options={"expose"=true})
     */
    public function searchSuggestionAction(Request $request)
    {
        $search = $request->query->get('search_in');
        $searchIn = $request->query->get('search_string');
        $em = $this->get('doctrine.orm.entity_manager');
        $results = array();
        if ($searchIn == 'real_estate' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
            $realEstate = $queryBuilder
                ->select('real_estate.title')
                ->from(get_class(new RealEstate()), 'real_estate')
                ->innerJoin('real_estate.area', 'area')
                ->where($queryBuilder->expr()->like('real_estate.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('real_estate.description', ':search'))
                ->orWhere($queryBuilder->expr()->like('area.name', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();

            foreach ($realEstate as $result) {
                $results[] = $result['title'];
            }

        }
        if ($searchIn == 'for_sale' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
            $forSale = $queryBuilder
                ->select('for_sale.title')
                ->from(get_class(new ForSale()), 'for_sale')
                ->where($queryBuilder->expr()->like('for_sale.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('for_sale.description', ':search'))
                ->orWhere($queryBuilder->expr()->like('for_sale.summary', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            foreach ($forSale as $result) {
                $results[] = $result['title'];
            }

        }
        if ($searchIn == 'cars' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
            $cars = $queryBuilder
                ->select('cars.title')
                ->from(get_class(new Car()), 'cars')
                ->innerJoin('cars.mark', 'mark')
                ->where($queryBuilder->expr()->like('cars.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('cars.type', ':search'))
                ->orWhere($queryBuilder->expr()->like('cars.description', ':search'))
                ->orWhere($queryBuilder->expr()->like('mark.name', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            foreach ($cars as $result) {
                $results[] = $result['title'];
            }
        }
        if ($searchIn == 'desouk_mall' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
            $desoukMall = $queryBuilder
                ->select('desouk_mall_products.name')
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
            foreach ($desoukMall as $result) {
                $results[] = $result['name'];
            }
        }

        if ($searchIn == 'jobs' || $searchIn == 'desouk_online' || $searchIn == '') {
            $queryBuilder = $em->createQueryBuilder();
            $jobs = $queryBuilder
                ->select('jobs.title')
                ->from(get_class(new Job()), 'jobs')
                ->where($queryBuilder->expr()->like('jobs.title', ':search'))
                ->orWhere($queryBuilder->expr()->like('jobs.description', ':search'))
                ->setParameters(array('search' => "%{$search}%"))
                ->getQuery()
                ->getResult();
            foreach ($jobs as $result) {
                $results[] = $result['title'];
            }
        }
//        $em = $this->get('doctrine.orm.entity_manager');
//        $dql = "SELECT p.name FROM ".get_class(new Product())." p where p.name like '%" . $search . "%' or p.description like '%" . $search . "%'";
//        $query = $em->createQuery($dql);
//        $searchResults = $query->getResult();
//        $results=array();
//        foreach($searchResults as $result){
//            $results[]=$result['name'];
//        }
        return new JsonResponse(array('results' => $results));

    }
}
