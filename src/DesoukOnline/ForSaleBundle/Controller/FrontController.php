<?php

namespace DesoukOnline\ForSaleBundle\Controller;

use DesoukOnline\ForSaleBundle\Entity\ForSaleConfig;
use DesoukOnline\HomeBundle\Entity\General;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
Use DesoukOnline\ForSaleBundle\Entity\ForSale;
use DesoukOnline\ForSaleBundle\Entity\Image;
Use DesoukOnline\ForSaleBundle\Entity\Category;

class FrontController extends Controller
{
    /**
     * @Route("/forSale", name="forSale")
     * @Template("DesoukOnlineForSaleBundle:Front:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $config = $this->getDoctrine()->getRepository(get_class(new General()))->getGeneralConfigurationsAndBundleConfigurations(get_class(new ForSaleConfig()));

        $repository = $this->getDoctrine()
            ->getRepository('DesoukOnlineForSaleBundle:ForSale');

        $query = $repository->createQueryBuilder('f')
			->leftJoin('f.category' ,'c');
		if ($request->query->get('cat') ) {
			$query->andWhere('c.title = :cat')
			->setParameter('cat',$request->query->get('cat'));
		}
        $query = $query->getQuery();

        $forSales_array = $query->getResult();
		
		$paginator = $this->get('knp_paginator');
        $forSales = $paginator->paginate(
            $forSales_array,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );
		
        return array('forSales' => $forSales,'config'=>$config);
    }
	
	/**
     * @Route("/forSale/{slug}", name="forSale_show")
     * @Template("DesoukOnlineForSaleBundle:Front:show.html.twig")
     */
    public function showAction($slug)
    {
        $config = $this->getDoctrine()->getRepository(get_class(new General()))->getGeneralConfigurationsAndBundleConfigurations(get_class(new ForSaleConfig()));

        $forSale = $this->getDoctrine()->getManager()->getRepository(get_class(new ForSale()))->findOneBy(array('slug' => $slug));
        $variables = array('forSale' => $forSale);
		if(is_file($forSale->getAbsolutePath())){
			$variables['has_slider'] = true;
		}
		else{
			$variables['has_slider'] = false;
		}
        $variables['config']=$config;
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
	
	
	///////////////////////////// Backend Delete Image //////////////////////////////
	/**
     * @Route("/admin/forSale/deleteImage/{forSale}/{image_id}" , name ="forSale_deleteImge")
     */
    public function deleteImageAction($forSale,$image_id)
    {
    	$url = $this->generateUrl(
            'admin_desoukonline_forsale_forsale_edit',
            array('id' => $forSale)
        );
		$image = $this->getDoctrine()->getManager()->getRepository(get_class(new Image()))->findOneBy(array('id' => $image_id));
		if (is_file($image->getAbsolutePath())) {
			unlink($image->getAbsolutePath());
		}
		$em = $this->getDoctrine()->getManager();
		$em->remove($image);
		$em->flush();
		
		return $this->redirect($url);
    }
}
