<?php

namespace DesoukOnline\HomeBundle\Controller;

use DesoukOnline\BannerBundle\Entity\Banner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller
{

    /**
     * @Route("/", name ="home")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/homepage.html.twig")
     */
    public function homeAction()
    {
    }

    /**
     * @Route("/header" , name ="header")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/header.html.twig")
     */
    public function headerAction()
    {
    }

    /**
     * @Route("/footer" , name ="footer")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/footer.html.twig")
     */
    public function footerAction()
    {
    }

    /**
     * @Route("/banner" , name ="banner")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/banner.html.twig")
     */
    public function bannerAction()
    {
        $banners = $this->getDoctrine()->getManager()->getRepository(get_class(new Banner()))->findAll();
        return array('banners' => $banners);
    }

    /**
     * @Route("/mainComponents" , name ="mainComponents")
     * @Template("DesoukOnlineHomeBundle:Front:Homepage/main_components.html.twig")
     */
    public function mainComponentsAction()
    {
    }


}
