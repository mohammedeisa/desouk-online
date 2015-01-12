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
}
