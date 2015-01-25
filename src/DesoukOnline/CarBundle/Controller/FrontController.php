<?php

namespace DesoukOnline\CarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
Use DesoukOnline\CarBundle\Entity\Car;
Use DesoukOnline\CarBundle\Entity\Mark;

class FrontController extends Controller
{
    /**
     * @Route("/car", name="car")
     * @Template("DesoukOnlineCarBundle:Front:index.html.twig")
     */
    public function indexAction(Request $request)
    {
    	$repository = $this->getDoctrine()
            ->getRepository('DesoukOnlineCarBundle:Car');

        $query = $repository->createQueryBuilder('c')
			->leftJoin('c.mark' ,'m');
		if ($request->query->get('type') ) {
			$query->andWhere('c.type = :type')
			->setParameter('type',$request->query->get('type'));
		}
		if ($request->query->get('mark') ) {
			$query->andWhere('m.name = :mark')
			->setParameter('mark',$request->query->get('mark'));
		}
        $query = $query->getQuery();

        $cars = $query->getResult();
        return array('cars' => $cars);
    }
	
	/**
     * @Route("/car/{slug}", name="car_show")
     * @Template("DesoukOnlineCarBundle:Front:show.html.twig")
     */
    public function showAction($slug)
    {
        $car = $this->getDoctrine()->getManager()->getRepository(get_class(new Car()))->findOneBy(array('slug' => $slug));
        $variables = array('car' => $car);
		if(is_file($car->getAbsolutePath())){
			$variables['has_slider'] = true;
		}
		else{
			$variables['has_slider'] = false;
		}
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
	
}
