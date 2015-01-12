<?php

namespace DesoukOnline\MallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller
{
    /**
     * @Route("/mall", name ="mall")
     * @Template("DesoukOnlineMallBundle:Front:Mall/index.html.twig")
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/mall/vendor/{slug}", name ="vendor")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor.html.twig")
     */
    public function vendorAction()
    {
    }


    /**
     * @Route("/mall/category/{slug}", name ="category")
     * @Template("DesoukOnlineMallBundle:Front:Mall/category.html.twig")
     */
    public function categoryAction()
    {
    }
}
