<?php

namespace DesoukOnline\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    /**
     * @Route("/faqs/{category}", name="faqs", defaults={"category" = null})
     * @Template("DesoukOnlineFaqBundle:Front:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $faqs = $this->getDoctrine()
            ->getRepository('DesoukOnlineFaqBundle:Faq');
        $currentCategory = null;
        if ($request->get('category')) {
            $category = $this->getDoctrine()
                ->getRepository('DesoukOnlineProductBundle:Category')->findOneBy(array('slug' => $request->get('category')));
            if ($category) {
                $faqs = $faqs->findBy(array('category' => $category->getId()));
                $currentCategory=$request->get('category');
            } else {
                $faqs = $faqs->findAll();
            }
        } else {
            $faqs = $faqs->findAll();
        }

        $categories = $this->getDoctrine()
            ->getRepository('DesoukOnlineProductBundle:Category')->findAll();
        $config = $this->get('request')->getSession()->get('tabs_config');
        $news = $em->createQuery('SELECT p FROM DesoukOnlineNewsBundle:News p')
            ->setMaxResults(5)->getResult();


        return array('faqs' => $faqs, 'config' => $config, 'news' => $news, 'categories' => $categories,'current_category'=>$currentCategory);
    }
}
