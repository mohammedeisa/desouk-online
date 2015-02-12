<?php

namespace DesoukOnline\DeliveryBundle\Controller;

use DesoukOnline\DeliveryBundle\Entity\Delivery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DesoukOnline\DeliveryBundle\Entity\MenuItem;
use DesoukOnline\DeliveryBundle\Entity\Menu;
use Symfony\Component\HttpFoundation\Request;

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
	
	///////////////////////////// Backend Delivery Menu Delete Item //////////////////////////////
    /**
     * @Route("/admin/delivery/deleteItem/{menu}/{item_id}" , name ="delivery_menu_deleteItem")
     */
    public function deletedeliveryMenuItemAction($menu, $item_id)
    {
        $url = $this->generateUrl(
            'admin_desoukonline_delivery_menu_edit',
            array('id' => $menu)
        );
        $item = $this->getDoctrine()->getManager()->getRepository(get_class(new MenuItem()))->findOneBy(array('id' => $item_id));
        if (is_file($item->getAbsolutePath())) {
            unlink($item->getAbsolutePath());
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        return $this->redirect($url);
    }
	
	/////////////// Frontend User Actions //////////////////////////////////////////////////
	/**
     * @Route("editDelivery/{delivery}" , name ="front_editDelivery")
	 * @Template("DesoukOnlineDeliveryBundle:Front:User/editDelivery.html.twig")
     */
    public function editDeliveryAction($delivery ,Request $request)
    {
    	$delivery = $this->getDoctrine()->getManager()->getRepository(get_class(new Delivery()))->findOneById($delivery);
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Vendor Form ////////////////////////////////////////////////////
    	$form = $this->get('form.factory')->createNamedBuilder('deliveryForm', 'form', $delivery, array())
	        ->add('title',null,array('label' => 'الاسم'))
			->add('description','ckeditor',array('label' => ' نبذة عن المحل'))
			->add('telephone',null,array('label' => 'تليفونات المحل'))
			->add('email',null,array('label' => 'البريد الاليكترونى'))
			->add('facebook',null,array('label' => ' صفحة الفيس بوك'))
			->add('file', 'file', array('required' => false,'label'=>'الشعار'))
			->add('save', 'submit', array('label' => 'تعديل'));
			
        $form = $form->getForm();
		////////////////////////////////////////////////////////////////////////////////////
        $form->handleRequest($request);
	    if ($form->isValid()) {
	    	if($delivery->getFile()){
	    		$delivery->upload();
	    	}
    		$em->persist($delivery);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
                'success',
                'تم التعديل بنجاح'
            );
			
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('delivery' => $delivery,'form' => $form->createView());
    }

	////////////////// Add Menus /////////////////////////////////////
	/**
     * @Route("editDelivery/menus/{delivery}" , name ="front_editDlivery_menus")
	 * @Template("DesoukOnlineDeliveryBundle:Front:User/editDelivery_menus.html.twig")
     */
    public function editDeliveryMenusAction($delivery ,Request $request)
    {
    	$delivery = $this->getDoctrine()->getManager()->getRepository(get_class(new Delivery()))->findOneById($delivery);
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Delivery Menu Form /////////////////////////////////////////
		$menu = new Menu();
		$menu->setDelivery($delivery);
	    $menu_form = $this->get('form.factory')->createNamedBuilder('menuForm', 'form', $menu, array())
			->add('title',null,array('label' => 'الاسم'))
			->add('description','ckeditor',array('label' => 'نبذة عن المنيو'))
			->add('file', 'file', array('required' => false,'label'=>'صورة المنيو'))
			->add('save', 'submit', array('label' => 'إضافة منيو'));
		$menu_form = $menu_form->getForm();
		
		////////////////////////////////////////////////////////////////////////////////////
		$menu_form->handleRequest($request);
	    if ($menu_form->isValid()) {
	    	if($menu->getFile()){
	    		$menu->upload();
	    	}
	    	$em->persist($menu);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
                'success',
                'تم إضافة المنيو بنجاح'
            );
			return $this->redirect($this->generateUrl('front_editDlivery_menus',array('delivery' => $delivery->getId())));
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('delivery' => $delivery,'menu_form' => $menu_form->createView());
    }

	////////////////// Edit Menu /////////////////////////////////////
	/**
     * @Route("editDelivery/menus/edit/{menu_id}" , name ="front_editDelivery_menus_edit")
	 * @Template("DesoukOnlineDeliveryBundle:Front:User/editDelivery_menus_edit.html.twig")
     */
    public function editVendorCategoriesEditAction($menu_id ,Request $request)
    {
    	$menu = $this->getDoctrine()->getManager()->getRepository(get_class(new Menu()))->findOneById($menu_id);
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Vendor Category Form /////////////////////////////////////////
	    $menu_form = $this->get('form.factory')->createNamedBuilder('menuForm', 'form', $menu, array())
			->add('title',null,array('label' => 'الاسم'))
			->add('description','ckeditor',array('label' => 'نبذة عن المنيو'))
			->add('file', 'file', array('required' => false,'label'=>'صورة المنيو'))
			->add('save', 'submit', array('label' => 'تعديل المنيو'));
		$menu_form = $menu_form->getForm();
		
		////////////////////////////////////////////////////////////////////////////////////
		$menu_form->handleRequest($request);
	    if ($menu_form->isValid()) {
	    	$em->persist($menu);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
                'success',
                'تم تعديل المنيو بنجاح'
            );
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('delivery' => $menu->getDelivery(),'menu_form' => $menu_form->createView());
    }

	///////////////////////////// FrontEnd Delivery Delete menu //////////////////////////////
	/**
     * @Route("/delivery/deleteMenu/{delivery}/{menu_id}" , name ="front_delivery_deleteMenu")
     */
    public function deleteFrontDeliveryMenuAction($delivery,$menu_id)
    {
    	$url = $this->generateUrl(
            'front_editDelivery',
            array('delivery' => $delivery)
        );
		$menu = $this->getDoctrine()->getManager()->getRepository(get_class(new Menu()))->findOneBy(array('id' => $menu_id));
		$em = $this->getDoctrine()->getManager();
		$em->remove($menu);
		$em->flush();
		
		return $this->redirect($url);
    }
	
	////////////////// menu items /////////////////////////////////////
	/**
     * @Route("editDelivery/products/{menu_id}" , name ="front_editDelivery_products")
	 * @Template("DesoukOnlineDeliveryBundle:Front:User/editDelivery_products.html.twig")
     */
    public function editDeliveryProductsAction($menu_id ,Request $request)
    {
    	$menu = $this->getDoctrine()->getManager()->getRepository(get_class(new Menu()))->findOneById($menu_id);
        $em = $this->getDoctrine()->getManager();
        /////////////////////////// Product Form /////////////////////////////////////////
        $product = new MenuItem();
		$product->setMenu($menu);
	    $product_form = $this->get('form.factory')->createNamedBuilder('ProductForm', 'form', $product, array())
			->add('title',null,array('label' => 'الاسم'))
			->add('description','ckeditor',array('label' => 'الوصف و البيانات'))
			->add('price',null,array('label' => 'السعر'))
			->add('file', 'file', array('required' => false,'label'=>'الصورة'))
			->add('save', 'submit', array('label' => 'إضافة الصنف'));
		$product_form = $product_form->getForm();
		
		
		////////////////////////////////////////////////////////////////////////////////////
	            // handle the first form
	            $product_form->handleRequest($request);
			    if ($product_form->isValid()) {
			    	if($product->getFile()){
			    		$product->upload();
			    	}
			    	$em->persist($product);
					$em->flush();
					$this->get('session')->getFlashBag()->add(
		                'success',
		                'تم إضافة الصنف بنجاح'
		            );
					//////////// Clear Form    ///////////////////////////////////////////////////
					$product = new MenuItem();
					$product->setMenu($menu);
				    $product_form = $this->get('form.factory')->createNamedBuilder('ProductForm', 'form', $product, array())
						->add('title',null,array('label' => 'الاسم'))
						->add('description','ckeditor',array('label' => 'الوصف و البيانات'))
						->add('price',null,array('label' => 'السعر'))
						->add('file', 'file', array('required' => false,'label'=>'الصورة'))
						->add('save', 'submit', array('label' => 'إضافة الصنف'));
					$product_form = $product_form->getForm();
					////////////////////////////////////////////////////////////////////////////// 
			    }
		/////////////////////////////////////////////////////////////////////////////////////
        return array('delivery' => $menu->getDelivery(),'menu' => $menu,'product_form' => $product_form->createView());
    }
    
    ////////////////// Edit Menu Item /////////////////////////////////////
	/**
     * @Route("editDelivery/products/edit/{product_id}" , name ="front_editDelivery_products_edit")
	 * @Template("DesoukOnlineDeliveryBundle:Front:User/editDelivery_products_edit.html.twig")
     */
    public function editDeliveryProductsEditAction($product_id ,Request $request)
    {
    	$product = $this->getDoctrine()->getManager()->getRepository(get_class(new MenuItem()))->findOneById($product_id);
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Product Form /////////////////////////////////////////
	    $product_form = $this->get('form.factory')->createNamedBuilder('ProductForm', 'form', $product, array())
			->add('title',null,array('label' => 'الاسم'))
			->add('description','ckeditor',array('label' => 'الوصف و البيانات'))
			->add('price',null,array('label' => 'السعر'))
			->add('menu',null,array('label' => 'المنيو','choices'   =>$product->getMenu()->getDelivery()->getMenus()))
			->add('file', 'file', array('required' => false,'label'=>'الصورة'))
			->add('save', 'submit', array('label' => 'تعديل الصنف'));
		$product_form = $product_form->getForm();
		
		
		////////////////////////////////////////////////////////////////////////////////////
	            // handle the first form
	            $product_form->handleRequest($request);
			    if ($product_form->isValid()) {
			    	if($product->getFile()){
			    		$product->upload();
			    	}
			    	$em->persist($product);
					$em->flush();
					$this->get('session')->getFlashBag()->add(
		                'success',
		                'تم تعديل الصنف بنجاح'
		            );
					$this->redirect($request->headers->get('referer'));
			    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('product' => $product,'delivery' => $product->getMenu()->getDelivery(),'product_form' => $product_form->createView());
    }

	///////////////////////////// FrontEnd Delivery Delete Menu Item //////////////////////////////
	/**
     * @Route("/delivery/deleteProduct/{menu_id}/{product_id}" , name ="front_delivery_deleteProduct")
     */
    public function deleteFrontDeliveryProductAction($menu_id,$product_id)
    {
    	$url = $this->generateUrl(
            'front_editDelivery_products',
            array('menu_id' => $menu_id)
        );
		$product = $this->getDoctrine()->getManager()->getRepository(get_class(new MenuItem()))->findOneBy(array('id' => $product_id));
		$em = $this->getDoctrine()->getManager();
		$em->remove($product);
		$em->flush();
		
		return $this->redirect($url);
    }

}
