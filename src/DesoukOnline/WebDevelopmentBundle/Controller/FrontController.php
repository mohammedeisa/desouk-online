<?php

namespace DesoukOnline\WebDevelopmentBundle\Controller;

use DesoukOnline\HomeBundle\Entity\General;
use DesoukOnline\WebDevelopmentBundle\Entity\Portfolio;
use DesoukOnline\WebDevelopmentBundle\Entity\WebDevelopment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller
{
    /**
     * @Route("/web_development",name="web_development")
     * @Template()
     */
    public function indexAction()
    {
        $config = $this->getDoctrine()->getRepository(get_class(new General()))->getGeneralConfigurationsAndBundleConfigurations(get_class(new WebDevelopment()));

        $em = $this->getDoctrine()->getManager();
        $webDevelopment = $em->createQuery('SELECT u FROM ' . get_class(new WebDevelopment()) . ' u')->getOneOrNullResult();
        $portfolio = $em->createQuery('SELECT u FROM ' . get_class(new Portfolio()) . ' u')->getOneOrNullResult();
        return array('web_development' => $webDevelopment, 'portfolio' => $portfolio, 'config' => $config);
    }
}
