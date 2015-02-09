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
        $deliveriesResult = $this->getDoctrine()->getManager()->getRepository(get_class(new Delivery()))->findAll();
        $paginator = $this->get('knp_paginator');
        $deliveries = $paginator->paginate(
            $deliveriesResult,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );
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
