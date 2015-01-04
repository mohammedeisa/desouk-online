<?php

namespace DesoukOnline\BannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    /**
     * @Route("/admin/banner/{title}")
     * @Template()
     */

   public function bannerAction($title)
   {
       $banner = $this->getDoctrine()
           ->getRepository('DesoukOnlineBannerBundle:Banner')
           ->findByTitle($title);

       return $this->render(
           'DesoukOnlineBannerBundle:Default:banner.html.twig',
           array('banner' => $banner)
       );


   }

}
