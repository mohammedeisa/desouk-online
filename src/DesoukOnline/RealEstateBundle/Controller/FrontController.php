<?php

namespace DesoukOnline\RealEstateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DesoukOnline\RealEstateBundle\Entity\RealEstate;
use DesoukOnline\RealEstateBundle\Entity\Area;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    /**
     * @Route("/realestate", name="realestate")
     * @Template("DesoukOnlineRealEstateBundle:Front:index.html.twig")
     */
    public function indexAction(Request $request)
    {
    	$repository = $this->getDoctrine()
            ->getRepository('DesoukOnlineRealEstateBundle:RealEstate');

        $query = $repository->createQueryBuilder('r')
			->leftJoin('r.area' ,'a');
		if ($request->query->get('purpose') && $request->query->get('purpose') != 'all') {
			$query->andWhere('r.purpose = :purpose')
			->setParameter('purpose',$request->query->get('purpose'));
		}
		if ($request->query->get('type') && $request->query->get('type') != 'all') {
			$query->andWhere('r.type = :type')
			->setParameter('type',$request->query->get('type'));
		}
		if ($request->query->get('area') && $request->query->get('area') != 'all') {
			$query->andWhere('a.name = :area')
			->setParameter('area',$request->query->get('area'));
		}	
        $query = $query->getQuery();

        $realestates = $query->getResult();
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
    public function sideFilterAction($purpose,$type,$area)
    {
    	$areas = $this->getDoctrine()->getManager()->getRepository(get_class(new Area()))->findAll();
        return array('areas' => $areas,'parameters'=>array('purpose' => $purpose,'type' => $type,'area' => $area));
    }
}
