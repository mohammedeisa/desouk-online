<?php

namespace DesoukOnline\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class FrontController extends Controller
{



    /**
     * @Route("/articles", name="articles")
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('DesoukOnlineArticleBundle:Category')->findAll();

        return $this->render(
            'DesoukOnlineArticleBundle:Front:index.html.twig',
            array('categories' => $categories)
        );
    }

    /**
     * @Route("/articles/{slug}", name="article_show")
     */
    public function articleShowAction($slug)
    {
        $aboutUs = $this->getDoctrine()
            ->getRepository('DesoukOnlineArticleBundle:Article')->findOneBy(array('slug' => $slug));
        $config=$this->get('request')->getSession()->get('tabs_config');
        return $this->render(
            'DesoukOnlineArticleBundle:Front:about_us.html.twig',
            array('aboutUs' => $aboutUs, 'config'=>$config));

    }

    /**
     * @Route("/about-us", name="about_us")
     */
    public function aboutUsAction()
    {
        $aboutUs = null;
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT a FROM DesoukOnlineArticleBundle:Article a where a.isAboutRoot=:isAboutRoot order by a.updatedAt DESC')
            ->setParameter('isAboutRoot', true);

        try {
            $aboutUs = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
        }
        $config=$this->get('request')->getSession()->get('tabs_config');
        return $this->render(
            'DesoukOnlineArticleBundle:Front:about_us.html.twig',
            array('aboutUs' => $aboutUs, 'config'=>$config));
    }

    /**
     * @Route("/vision", name="vision")
     * @Template("DesoukOnlineArticleBundle:Front:vision.html.twig")
     */
    public function visionAction()
    {
        $vision = null;
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT a FROM DesoukOnlineArticleBundle:Article a where a.isVision=:isVision order by a.updatedAt DESC')
            ->setParameter('isVision', true);

        try {
            $vision = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
        }

        $config=$this->get('request')->getSession()->get('tabs_config');
        return array('vision' => $vision, 'config'=>$config);
    }

    /**
     * @Route("/philosophy", name="philosophy")
     * @Template("DesoukOnlineArticleBundle:Front:philosophy.html.twig")
     */
    public function philosophyAction()
    {
        $philosophy = null;
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT a FROM DesoukOnlineArticleBundle:Article a where a.isPhilosophy=:isPhilosophy order by a.updatedAt DESC')
            ->setParameter('isPhilosophy', true);

        try {
            $philosophy = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
        }
        $config=$this->get('request')->getSession()->get('tabs_config');
        return array('philosophy' => $philosophy, 'config'=>$config);
    }

    /**
     * @Route("/life_at_ultimatrue", name="life_at_ultimatrue")
     * @Template("DesoukOnlineArticleBundle:Front:life_at_ultimatrue.html.twig")
     */
    public function lifeAtUltimatrueAction()
    {
        $lifeAtUltimatrue = null;
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT a FROM DesoukOnlineArticleBundle:Article a where a.isLifeAtUltimatrue=:lifeAtUltimatrue order by a.updatedAt DESC')
            ->setParameter('lifeAtUltimatrue', true);
        try {
            $lifeAtUltimatrue = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
        }
        $config=$this->get('request')->getSession()->get('tabs_config');
        return array('life_at_ultimatrue' => $lifeAtUltimatrue, 'config'=>$config);
    }



    /**
     * @Route("/articles/category/{slug}", name="article_category")
     */
    public function articleCategoryAction($slug)
    {
        $category = $this->getDoctrine()
            ->getRepository('DesoukOnlineArticleBundle:Category')->findOneBy(array('slug' => $slug));
        return $this->render(
            'DesoukOnlineArticleBundle:Front:category.html.twig',
            array('category' => $category)
        );
    }

}
