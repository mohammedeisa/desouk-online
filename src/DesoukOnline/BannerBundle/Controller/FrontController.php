<?php

namespace DesoukOnline\BannerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller
{
    /**
     * @Route("/banner")
     * @Template("DesoukOnlineBannerBundle:Front:banner.html.twig")
     */

    public function bannerAction($configBanner, $itemBanner)
    {
        $banner = null;
        if ($itemBanner) {
            $banner = $itemBanner;
        } elseif ($configBanner) {
            $banner = $configBanner;
        }
        return array('banner'=>$banner);
    }

}
