<?php

namespace DesoukOnline\SponsorBundle\Controller;

use DesoukOnline\SponsorBundle\Entity\Sponsor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller
{
    /**
     * @Route("/sponsors")
     * @Template("DesoukOnlineSponsorBundle:Front:sponsors.html.twig")
     */
    public function indexAction()
    {
        $sponsors = $this->getDoctrine()->getManager()->getRepository(get_class(new Sponsor()))->findBy(array('inHome' => true));
        return array('sponsors' => $sponsors);
    }
}
