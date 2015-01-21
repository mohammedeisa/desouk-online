<?php

namespace DesoukOnline\RealEstateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DesoukOnline\RealEstateBundle\Entity\RealEstate;
use DesoukOnline\RealEstateBundle\Entity\Area;

class FrontController extends Controller
{
    /**
     * @Route("/realestate", name="realestate")
     * @Template("DesoukOnlineRealEstateBundle:Front:index.html.twig")
     */
    public function indexAction()
    {
        $realestates = $this->getDoctrine()->getManager()->getRepository(get_class(new RealEstate()))->findAll();
        return array('realestates' => $realestates);
    }
	
	/**
     * @Route("/realestate/{slug}", name="realestate_show")
     * @Template("DesoukOnlineRealEstateBundle:Front:show.html.twig")
     */
    public function showAction($slug)
    {
        $realestate = $this->getDoctrine()->getManager()->getRepository(get_class(new RealEstate()))->findOneBy(array('slug' => $slug));
        $variables = array('realestate' => $realestate);
		if(is_file($realestate->getAbsolutePath())){
			$variables['has_slider'] = true;
		}
		else{
			$variables['has_slider'] = false;
		}
        return $variables;
    }
	
	/**
     * @Route("/side_filter" , name ="side_filter")
     * @Template("DesoukOnlineRealEstateBundle:Front:side_filter.html.twig")
     */
    public function sideFilterAction()
    {
    	$areas = $this->getDoctrine()->getManager()->getRepository(get_class(new Area()))->findAll();
        return array('areas' => $areas);
    }
}
