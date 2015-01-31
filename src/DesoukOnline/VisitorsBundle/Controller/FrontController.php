<?php

namespace DesoukOnline\VisitorsBundle\Controller;

use DesoukOnline\VisitorsBundle\Entity\Visitors;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{


    /**
     * @Route("/visitors", name="visitors" )
     */
    public function visitorsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $url = $_SERVER['REQUEST_URI'];
        $count = 0;
        $visitorsCount = $em->getRepository(get_class(new Visitors()))->findOneBy(array('url' => $url));
        if ($visitorsCount) {
            $count = $visitorsCount->getCount() + 1;
            $visitorsCount->setCount($count);
            $em->persist($visitorsCount);
            $em->flush();
        } else {
            $count = 1;
            $visitorsCount = new Visitors();
            $visitorsCount->setCount($count);
            $visitorsCount->setUrl($url);
            $em->persist($visitorsCount);
            $em->flush();
        }
        $visitorsString = ' زائر';
        return new Response($count . $visitorsString);
    }
}
