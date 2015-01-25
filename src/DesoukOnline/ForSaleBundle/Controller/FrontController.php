<?php

namespace DesoukOnline\ForSaleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
Use DesoukOnline\ForSaleBundle\Entity\ForSale;
Use DesoukOnline\ForSaleBundle\Entity\Category;

class FrontController extends Controller
{
    /**
     * @Route("/forSale", name="forSale")
     * @Template("DesoukOnlineForSaleBundle:Front:index.html.twig")
     */
    public function indexAction(Request $request)
    {
    	$repository = $this->getDoctrine()
            ->getRepository('DesoukOnlineForSaleBundle:ForSale');

        $query = $repository->createQueryBuilder('f')
			->leftJoin('f.category' ,'c');
		if ($request->query->get('cat') ) {
			$query->andWhere('c.title = :cat')
			->setParameter('cat',$request->query->get('cat'));
		}
        $query = $query->getQuery();

        $forSales = $query->getResult();
        return array('forSales' => $forSales);
    }
	
	/**
     * @Route("/forSale/{slug}", name="forSale_show")
     * @Template("DesoukOnlineForSaleBundle:Front:show.html.twig")
     */
    public function showAction($slug)
    {
        $forSale = $this->getDoctrine()->getManager()->getRepository(get_class(new ForSale()))->findOneBy(array('slug' => $slug));
        $variables = array('forSale' => $forSale);
		if(is_file($forSale->getAbsolutePath())){
			$variables['has_slider'] = true;
		}
		else{
			$variables['has_slider'] = false;
		}
        return $variables;
    }

	
	/**
     * @Route("/forSale/side_filter" , name ="forSale_side_filter")
     * @Template("DesoukOnlineForSaleBundle:Front:side_filter.html.twig")
     */
    public function sideFilterAction($cat)
    {
    	$cats = $this->getDoctrine()->getManager()->getRepository(get_class(new Category()))->findAll();
        return array('cats' => $cats,'parameters'=>array('cat' => $cat));
    }
}
