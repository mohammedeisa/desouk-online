<?php

namespace DesoukOnline\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("admin/article_cat_tree_up/{id}",name = "article_cat_tree_up")
     * @Template()
     */
    public function moveupAction($id)
    {
        {
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('DesoukOnlineArticleBundle:Category');
            $page = $repo->find($id);
            if ($page->getParent()){
                $repo->moveUp($page);
            }else{
                // get Max position
                $qb = $repo->createQueryBuilder('p');
                $qb->addSelect('MIN(p.position)as position')->orderBy('p.position', 'DESC');
                $result = $qb->getQuery()->getResult();
                $result = $result[0];
                $min_position = $result['position'];
                if($page->getPosition()!=$min_position){

                    $root_position = $page->getPosition();
                    $oldposition = $repo->findByposition($root_position);

                    $up_position = $root_position-1;
                    $next_tree =  $repo->findByposition($up_position);
                    foreach($oldposition as $node){
                        $node->setPosition($up_position);
                        $em->persist($node);

                    }

                    foreach($next_tree as $node){
                        $node->setPosition($root_position);
                        $em->persist($node);

                    }
                    $em->flush();

                }

            }

            return $this->redirect($this->getRequest()->headers->get('referer'));
        } new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }
    /**
     * @Route("admin/article_cat_tree_down/{id}",name = "article_cat_tree_down")
     * @Template()
     */

    public function movedownAction($id)
    {
        {
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('DesoukOnlineArticleBundle:Category');
            $page = $repo->find($id);
            if ($page->getParent()){
                $repo->moveDown($page);
            }else{
                // get Max position
                $qb = $repo->createQueryBuilder('p');
                $qb->addSelect('MAX(p.position)as position')->orderBy('p.position', 'DESC');
                $result = $qb->getQuery()->getResult();
                $result = $result[0];
                $max_position = $result['position'];
                if($page->getPosition()!=$max_position){

                    $root_position = $page->getPosition();
                    $oldposition = $repo->findByposition($root_position);

                    $down_position = $root_position+1;
                    $next_tree =  $repo->findByposition($down_position);
                    foreach($oldposition as $node){
                        $node->setPosition($down_position);
                        $em->persist($node);

                    }

                    foreach($next_tree as $node){
                        $node->setPosition($root_position);
                        $em->persist($node);

                    }
                    $em->flush();

                }

            }

            return $this->redirect($this->getRequest()->headers->get('referer'));
        } new RedirectResponse($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }

    /**
     * @Route("admin/category/{id}")
     */

    public function categoryAction($id){

        $repo = $this->getDoctrine()
            ->getRepository('DesoukOnlineArticleBundle:Category');


        $cat =  $repo->find($id);
        $articles =  $cat->getCategoryArticle();
        $varticles = array();
        foreach($articles as $article){

            $temp = $article->getIdArticle();
            array_push($varticles,$temp);



        }

        return $this->render(
            'DesoukOnlineArticleBundle:Default:categoryArticles.html.twig',
            array('articles' => $varticles)


        );



    }

    /**
     * @Route("admin/category")
     */

    public function allCategoryAction(){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DesoukOnlineArticleBundle:Category');
        $query =  $repo
            ->createQueryBuilder('node')
            ->select('node')
            ->from('DesoukOnlineArticleBundle:Category', 'p')
            ->orderBy('node.position , node.root, node.lft', 'ASC')
            ->where('node.id = p.id')
            ->getQuery()
        ;
        $options = array('decorate' => true,'rootOpen' => '<ul>',
            'rootClose' => '</ul>',
            'childOpen' => '<li>',
            'childClose' => '</li>',
            'nodeDecorator' => function($node) {
                    return '<a href="./category/'.$node['id'].'">'.$node['name'].'</a>';
                }
        );
        $tree = $repo->buildTree($query->getArrayResult(), $options);


        return $this->render(
            'DesoukOnlineArticleBundle:Default:category.html.twig',
            array('cats' => $tree)
        );

    }

    /**
     * @Route("admin/article/{id}")
     */

    public function articleAction($id){

        $repo = $this->getDoctrine()
            ->getRepository('DesoukOnlineArticleBundle:Article')->find($id);

        return $this->render(
            'DesoukOnlineArticleBundle:Default:article.html.twig',
            array('article' => $repo )
        );

    }
    /**
     * @Route("admin/categoryChildrenArticle/{id}")
     */
    public function categoryChildrenArticle($id){


        $repo = $this->getDoctrine()
            ->getRepository('DesoukOnlineArticleBundle:Category');


        $cat =  $repo->find($id);
        if($cat){
            $articles =  $cat->getCategoryArticle();
            $vArticles = array();
            foreach($articles as $article){

                $temp = $article->getIdArticle();
                array_push($vArticles,$temp);

            }
            $children = $repo->children($cat);
            foreach($children as $child){
                $articles =  $child->getCategoryArticle();
                foreach($articles as $artilce){

                    $temp = $article->getIdArticle();
                    array_push($vArticles,$temp);

                }
            }

            return $this->render(
                'DesoukOnlineArticleBundle:Default:categoryArticles.html.twig',
                array('articles' => $vArticles));
        }else{
            return $this->render(
                'DesoukOnlineArticleBundle:Default:categoryArticles.html.twig',
                array('articles' => ''));

        }



    }





}
