<?php

namespace DesoukOnline\DeliveryBundle\Controller;

use DesoukOnline\DeliveryBundle\Entity\Delivery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller
{
    /**
     * @Route("/delivery", name="delivery")
     * @Template("DesoukOnlineDeliveryBundle:Front:index.html.twig")
     */
    public function indexAction()
    {
        $deliveries = $this->getDoctrine()->getManager()->getRepository(get_class(new Delivery()))->findAll();
        return array('deliveries' => $deliveries);
    }

    /**
     * @Route("/delivery/{slug}", name="delivery_delivery")
     * @Template("DesoukOnlineDeliveryBundle:Front:delivery.html.twig")
     */
    public function deliveryAction()
    {
        $delivery = $this->getDoctrine()->getManager()->getRepository(get_class(new Delivery()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('delivery' => $delivery);
    }

}
