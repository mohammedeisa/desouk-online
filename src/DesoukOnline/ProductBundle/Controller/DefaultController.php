<?php

namespace DesoukOnline\ProductBundle\Controller;

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
     * @Route("admin/cat_tree_up/{id}",name = "cat_tree_up")
     * @Template()
     */
    public function moveupAction($id)
    {
        {
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('DesoukOnlineProductBundle:Category');
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
     * @Route("admin/cat_tree_down/{id}",name = "cat_tree_down")
     * @Template()
     */

    public function movedownAction($id)
    {
        {
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository('DesoukOnlineProductBundle:Category');
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
            ->getRepository('DesoukOnlineProductBundle:Category');


                $cat =  $repo->find($id);
                 $products =  $cat->getCategoryProduct();
                 $vProducts = array();
                 foreach($products as $product){

                     $temp = $product->getIdProduct();
                    array_push($vProducts,$temp);



                 }

        return $this->render(
            'DesoukOnlineProductBundle:Default:categoryProducts.html.twig',
            array('products' => $vProducts)


        );



    }

    /**
     * @Route("admin/category")
     */

public function allCategoryAction(){
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('DesoukOnlineProductBundle:Category');
    $query =  $repo
        ->createQueryBuilder('node')
        ->select('node')
        ->from('DesoukOnlineProductBundle:Category', 'p')
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
        'DesoukOnlineProductBundle:Default:category.html.twig',
        array('cats' => $tree)
    );

}

    /**
     * @Route("admin/product/{id}")
     */

    public function productAction($id){

        $repo = $this->getDoctrine()
            ->getRepository('DesoukOnlineProductBundle:Product')->find($id);

        return $this->render(
            'DesoukOnlineProductBundle:Default:product.html.twig',
            array('product' => $repo )
        );

    }
    /**
     * @Route("admin/categoryChildrenProduct/{id}")
     */
public function categoryChildrenProduct($id){


    $repo = $this->getDoctrine()
        ->getRepository('DesoukOnlineProductBundle:Category');


    $cat =  $repo->find($id);
    if($cat){
        $products =  $cat->getCategoryProduct();
        $vProducts = array();
        foreach($products as $product){

            $temp = $product->getIdProduct();
            array_push($vProducts,$temp);

        }
        $children = $repo->children($cat);
        foreach($children as $child){
            $products =  $child->getCategoryProduct();
            foreach($products as $product){

                $temp = $product->getIdProduct();
                array_push($vProducts,$temp);

            }
        }

        return $this->render(
            'DesoukOnlineProductBundle:Default:categoryProducts.html.twig',
            array('products' => $vProducts));
    }else{
        return $this->render(
            'DesoukOnlineProductBundle:Default:categoryProducts.html.twig',
            array('products' => ''));

    }



}





}
