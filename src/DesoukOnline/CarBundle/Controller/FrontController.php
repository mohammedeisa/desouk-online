<?php

namespace DesoukOnline\CarBundle\Controller;

use DesoukOnline\CarBundle\Entity\CarConfig;
use DesoukOnline\HomeBundle\Entity\General;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
Use DesoukOnline\CarBundle\Entity\Car;
use DesoukOnline\CarBundle\Entity\Image;
Use DesoukOnline\CarBundle\Entity\Mark;

class FrontController extends Controller
{
    /**
     * @Route("/car", name="car")
     * @Template("DesoukOnlineCarBundle:Front:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $config = $this->getDoctrine()->getRepository(get_class(new General()))->getGeneralConfigurationsAndBundleConfigurations(get_class(new CarConfig()));
    	$repository = $this->getDoctrine()
            ->getRepository('DesoukOnlineCarBundle:Car');

        $query = $repository->createQueryBuilder('c')
			->leftJoin('c.mark' ,'m')
			->orderBy("c.createdAt", 'DESC');
		if ($request->query->get('type') ) {
			$query->andWhere('c.type = :type')
			->setParameter('type',$request->query->get('type'));
		}
		if ($request->query->get('mark') ) {
			$query->andWhere('m.name = :mark')
			->setParameter('mark',$request->query->get('mark'));
		}
        $query = $query->getQuery();

        $cars_array = $query->getResult();
		$paginator = $this->get('knp_paginator');
        $cars = $paginator->paginate(
            $cars_array,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return array('cars' => $cars,'config'=>$config);
    }
	
	/**
     * @Route("/car/{slug}", name="car_show")
     * @Template("DesoukOnlineCarBundle:Front:show.html.twig")
     */
    public function showAction($slug)
    {
        $config = $this->getDoctrine()->getRepository(get_class(new General()))->getGeneralConfigurationsAndBundleConfigurations(get_class(new CarConfig()));
        $car = $this->getDoctrine()->getManager()->getRepository(get_class(new Car()))->findOneBy(array('slug' => $slug));
        $variables = array('car' => $car);
		if(is_file($car->getAbsolutePath())){
			$variables['has_slider'] = true;
		}
		else{
			$variables['has_slider'] = false;
		}
        $variables['config']=$config;
        return $variables;
    }

	
	/**
     * @Route("/car/side_filter" , name ="car_side_filter")
     * @Template("DesoukOnlineCarBundle:Front:side_filter.html.twig")
     */
    public function sideFilterAction($type,$mark)
    {
    	$marks = $this->getDoctrine()->getManager()->getRepository(get_class(new Mark()))->findAll();
        return array('marks' => $marks,'parameters'=>array('type' => $type,'mark' => $mark));
    }
	
	///////////////////////////// Backend Delete Image //////////////////////////////
	/**
     * @Route("/admin/car/deleteImage/{car}/{image_id}" , name ="car_deleteImge")
     */
    public function deleteImageAction($car,$image_id)
    {
    	$url = $this->generateUrl(
            'admin_desoukonline_car_car_edit',
            array('id' => $car)
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
