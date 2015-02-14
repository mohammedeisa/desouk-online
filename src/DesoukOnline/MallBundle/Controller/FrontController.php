<?php

namespace DesoukOnline\MallBundle\Controller;

use DesoukOnline\MallBundle\Entity\Article;
use DesoukOnline\MallBundle\Entity\MallConfig;
use DesoukOnline\MallBundle\Entity\Product;
use DesoukOnline\MallBundle\Entity\Vendor;
use DesoukOnline\MallBundle\Entity\VendorImage;
use DesoukOnline\MallBundle\Entity\ProductImage;
use DesoukOnline\MallBundle\Entity\VendorProductCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DesoukOnline\MallBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    /**
     * @Route("/mall", name ="mall")
     * @Template("DesoukOnlineMallBundle:Front:Mall/index.html.twig")
     */
    public function indexAction()
    {
        $config = null;
        $query = $this->getDoctrine()->getManager()
            ->createQuery('SELECT p FROM ' . get_class(new MallConfig()) . ' p ');
        try {
            $config = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
        $categoriesResult = $this->getDoctrine()->getManager()->getRepository(get_class(new Category()))->findAll();

        $paginator = $this->get('knp_paginator');
        $categories = $paginator->paginate(
            $categoriesResult,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return array('categories' => $categories, 'config' => $config);
    }

    /**
     * @Route("/mall/category/{slug}", name ="mall_category")
     * @Template("DesoukOnlineMallBundle:Front:Mall/category.html.twig")
     */
    public function categoryAction()
    {
        $category = $this->getDoctrine()->getManager()->getRepository(get_class(new Category()))->findOneBy(array('slug' => $this->get('request')->get('slug')));

        $paginator = $this->get('knp_paginator');
        $categoryVendors = $paginator->paginate(
            $category->getVendors(),
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );
        return array('category' => $category, 'category_vendors' => $categoryVendors);

    }

    /**
     * @Route("/mall/vendor/{slug}", name ="vendor")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor.html.twig")
     */
    public function vendorAction()
    {
        $vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('vendor' => $vendor);
    }

    /**
     * @Route("/mall/vendor/product_category/{slug}", name ="vendor_product_category")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor_product_category.html.twig")
     */
    public function vendorProductCategoryAction()
    {
        $vendorProductCategory = $this->getDoctrine()->getManager()->getRepository(get_class(new VendorProductCategory()))->findOneBy(array('slug' => $this->get('request')->get('slug')));

        $paginator = $this->get('knp_paginator');
        $categoryProducts = $paginator->paginate(
            $vendorProductCategory->getProducts(),
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );

        return array('vendor_product_category' => $vendorProductCategory, 'category_products' => $categoryProducts);
    }


    /**
     * @Route("/mall/vendor/product/{slug}", name ="vendor_product")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor_product.html.twig")
     */
    public function vendorProductAction()
    {
        $product = $this->getDoctrine()->getManager()->getRepository(get_class(new Product()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('product' => $product);
    }


    /**
     * @Route("/mall/vendor/article/{slug}", name ="vendor_article")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor_article.html.twig")
     */
    public function vendorArticleAction()
    {
        $article = $this->getDoctrine()->getManager()->getRepository(get_class(new Article()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('article' => $article);
    }

    /**
     * @Route("/vendor_menu/{vendor}" , name ="vendor_menu")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor_menu.html.twig")
     */
    public function vendorMenuAction()
    {
        $vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('vendor' => $vendor);
    }

    /**
     * @Route("/vendor_header_menu/{vendor}" , name ="vendor_header_menu")
     * @Template("DesoukOnlineMallBundle:Front:Mall/vendor_header_menu.html.twig")
     */
    public function vendorHeaderMenuAction()
    {
        $vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('vendor' => $vendor);
    }
    ///////////////////////////// Backend Vendor Delete Image //////////////////////////////
    /**
     * @Route("/admin/vendor/deleteImage/{vendor}/{image_id}" , name ="vendor_deleteImge")
     */
    public function deleteVendorImageAction($vendor, $image_id)
    {
        $url = $this->generateUrl(
            'admin_desoukonline_mall_vendor_edit',
            array('id' => $vendor)
        );
        $image = $this->getDoctrine()->getManager()->getRepository(get_class(new VendorImage()))->findOneBy(array('id' => $image_id));
        if (is_file($image->getAbsolutePath())) {
            unlink($image->getAbsolutePath());
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();

        return $this->redirect($url);
    }

    ///////////////////////////// Backend Product Delete Image //////////////////////////////
    /**
     * @Route("/admin/product/deleteImage/{product}/{image_id}" , name ="product_deleteImge")
     */
    public function deleteProductImageAction($product, $image_id)
    {
        $url = $this->generateUrl(
            'admin_desoukonline_mall_product_edit',
            array('id' => $product)
        );
        $image = $this->getDoctrine()->getManager()->getRepository(get_class(new ProductImage()))->findOneBy(array('id' => $image_id));
        if (is_file($image->getAbsolutePath())) {
            unlink($image->getAbsolutePath());
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();

        return $this->redirect($url);
    }
	
	/////////////// Frontend User Actions //////////////////////////////////////////////////
	/**
     * @Route("editVendor/{vendor}" , name ="front_editVendor")
	 * @Template("DesoukOnlineMallBundle:Front:User/editVendor.html.twig")
     */
    public function editVendorAction($vendor ,Request $request)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($vendor)) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Vendor Form ////////////////////////////////////////////////////
    	$form = $this->get('form.factory')->createNamedBuilder('vendorForm', 'form', $vendor, array())
	        ->add('title',null,array('label' => 'الاسم'))
			->add('category',null,array('label' => 'التصنيف','required' => true))
			->add('file', 'file', array('required' => false,'label'=>'الشعار'))
			->add('save', 'submit', array('label' => 'تعديل'));
			
        $form = $form->getForm();
		/////////////////////////// Vendor image Form /////////////////////////////////////////
		$vendor_image = new VendorImage();
		$vendor_image->setVendor($vendor);
	    $vendor_image_form = $this->get('form.factory')->createNamedBuilder('vendorImageForm', 'form', $vendor_image, array())
			->add('file', 'file', array('required' => false,'label'=>false))
			->add('save', 'submit', array('label' => 'إضافة الصورة'));
		$vendor_image_form = $vendor_image_form->getForm();
		
		////////////////////////////////////////////////////////////////////////////////////
		if('POST' === $request->getMethod()) {
			if ($request->request->has($form->getName())) {
	            // handle the first form
	            $form->handleRequest($request);
			    if ($form->isValid()) {
			    	if($vendor->getFile()){
			    		$vendor->upload();
			    	}
		    		$em->persist($vendor);
					$em->flush();
					$this->get('session')->getFlashBag()->add(
		                'success',
		                'تم التعديل بنجاح'
		            );
					
			    }
	        }
	
	        if ($request->request->has($vendor_image_form->getName())) {
	            // handle the second form
	            $vendor_image_form->handleRequest($request);
			    if ($vendor_image_form->isValid()) {
			    	if($vendor_image->getFile()){
			    		$vendor_image->upload();
						$em->persist($vendor_image);
						$em->flush();
						$this->get('session')->getFlashBag()->add(
			                'success',
			                'تم إضافة بانر بنجاح '
			            );
			    	}
			    }
	        }
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('vendor' => $vendor,'form' => $form->createView(),'vendor_image_form' => $vendor_image_form->createView());
    }
    
    ///////////////////////////// FrontEnd Vendor Delete Image //////////////////////////////
	/**
     * @Route("/vendor/deleteImage/{vendor}/{image_id}" , name ="front_vendor_deleteImge")
     */
    public function deleteFrontVendorImageAction($vendor,$image_id)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($vendor)) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$url = $this->generateUrl(
            'front_editVendor',
            array('vendor' => $vendor)
        );
		$image = $this->getDoctrine()->getManager()->getRepository(get_class(new VendorImage()))->findOneBy(array('id' => $image_id));
		if (is_file($image->getAbsolutePath())) {
			unlink($image->getAbsolutePath());
		}
		$em = $this->getDoctrine()->getManager();
		$em->remove($image);
		$em->flush();
		
		return $this->redirect($url);
    }
	
	////////////////// Add Categories /////////////////////////////////////
	/**
     * @Route("editVendor/categories/{vendor}" , name ="front_editVendor_categories")
	 * @Template("DesoukOnlineMallBundle:Front:User/editVendor_categories.html.twig")
     */
    public function editVendorCategoriesAction($vendor ,Request $request)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($vendor)) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Vendor Category Form /////////////////////////////////////////
		$vendor_product_category = new VendorProductCategory();
		$vendor_product_category->setVendor($vendor);
	    $vendor_product_category_form = $this->get('form.factory')->createNamedBuilder('vendorProductCategoryForm', 'form', $vendor_product_category, array())
			->add('title',null,array('label' => 'الاسم'))
			->add('isInHome',null,array('label' => 'الظهور فى الصفحة الرئيسية للمحل','required'  => false,))
			->add('save', 'submit', array('label' => 'إضافة قسم'));
		$vendor_product_category_form = $vendor_product_category_form->getForm();
		
		////////////////////////////////////////////////////////////////////////////////////
		$vendor_product_category_form->handleRequest($request);
	    if ($vendor_product_category_form->isValid()) {
	    	$em->persist($vendor_product_category);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
                'success',
                'تم إضافة القسم بنجاح'
            );
			return $this->redirect($this->generateUrl('front_editVendor_categories',array('vendor' => $vendor->getId())));
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    $paginator = $this->get('knp_paginator');
        $vendor_product_categories = $paginator->paginate(
            $vendor->getVendorProductCategories(),
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return array('vendor' => $vendor,'categories' => $vendor_product_categories,'vendor_product_category_form' => $vendor_product_category_form->createView());
    }

	////////////////// Edit Category /////////////////////////////////////
	/**
     * @Route("editVendor/categories/edit/{category_id}" , name ="front_editVendor_categories_edit")
	 * @Template("DesoukOnlineMallBundle:Front:User/editVendor_categories_edit.html.twig")
     */
    public function editVendorCategoriesEditAction($category_id ,Request $request)
    {
    	$vendor_product_category = $this->getDoctrine()->getManager()->getRepository(get_class(new VendorProductCategory()))->findOneById($category_id);
    	if (!$this->isAuthenticated($vendor_product_category->getVendor())) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Vendor Category Form /////////////////////////////////////////
	    $vendor_product_category_form = $this->get('form.factory')->createNamedBuilder('vendorProductCategoryForm', 'form', $vendor_product_category, array())
			->add('title',null,array('label' => 'الاسم'))
			->add('isInHome',null,array('label' => 'الظهور فى الصفحة الرئيسية للمحل','required'  => false,))
			->add('save', 'submit', array('label' => 'تعديل القسم'));
		$vendor_product_category_form = $vendor_product_category_form->getForm();
		
		////////////////////////////////////////////////////////////////////////////////////
		$vendor_product_category_form->handleRequest($request);
	    if ($vendor_product_category_form->isValid()) {
	    	$em->persist($vendor_product_category);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
                'success',
                'تم تعديل القسم بنجاح'
            );
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('vendor' => $vendor_product_category->getVendor(),'vendor_product_category_form' => $vendor_product_category_form->createView());
    }

	///////////////////////////// FrontEnd Vendor Delete Category //////////////////////////////
	/**
     * @Route("/vendor/deleteCategory/{vendor}/{category_id}" , name ="front_vendor_deleteCategory")
     */
    public function deleteFrontVendorCategoryAction($vendor,$category_id)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($vendor)) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$url = $this->generateUrl(
            'front_editVendor_categories',
            array('vendor' => $vendor)
        );
		$category = $this->getDoctrine()->getManager()->getRepository(get_class(new VendorProductCategory()))->findOneBy(array('id' => $category_id));
		$em = $this->getDoctrine()->getManager();
		$em->remove($category);
		$em->flush();
		
		return $this->redirect($url);
    }
	
	////////////////// Products /////////////////////////////////////
	/**
     * @Route("editVendor/products/{vendor}" , name ="front_editVendor_products")
	 * @Template("DesoukOnlineMallBundle:Front:User/editVendor_products.html.twig")
     */
    public function editVendorProductsAction($vendor ,Request $request)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($vendor)) {
			return $this->redirect($this->generateUrl('home'));
		}
        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $vendor->getProducts(),
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return array('vendor' => $vendor,'products' => $products);
    }
    
	////////////////// Edit Product /////////////////////////////////////
	/**
     * @Route("editVendor/products/edit/{product_id}" , name ="front_editVendor_products_edit")
	 * @Template("DesoukOnlineMallBundle:Front:User/editVendor_products_edit.html.twig")
     */
    public function editVendorProductsEditAction($product_id ,Request $request)
    {
    	$product = $this->getDoctrine()->getManager()->getRepository(get_class(new Product()))->findOneById($product_id);
    	if (!$this->isAuthenticated($product->getVendor())) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Product Form /////////////////////////////////////////
	    $product_form = $this->get('form.factory')->createNamedBuilder('ProductForm', 'form', $product, array())
			->add('name',null,array('label' => 'الاسم'))
			->add('description','ckeditor',array('label' => 'الوصف و البيانات'))
			->add('code',null,array('label' => 'كود المنتج'))
			->add('price',null,array('label' => 'السعر'))
			->add('vendorProductCategory',null,array('label' => 'القسم','choices'   =>$product->getVendor()->getVendorProductCategories()))
			->add('isInHome',null,array('label' => 'الظهور فى الصفحة الرئيسية للمحل','required'  => false,))
			->add('file', 'file', array('required' => false,'label'=>'الصورة الرئيسية'))
			->add('save', 'submit', array('label' => 'تعديل المنتج'));
		$product_form = $product_form->getForm();
		
		/////////////////////////// Vendor image Form /////////////////////////////////////////
		$product_image = new ProductImage();
		$product_image->setProduct($product);
	    $product_image_form = $this->get('form.factory')->createNamedBuilder('productImageForm', 'form', $product_image, array())
			->add('file', 'file', array('required' => false,'label'=>false))
			->add('save', 'submit', array('label' => 'إضافة الصورة'));
		$product_image_form = $product_image_form->getForm();
		
		////////////////////////////////////////////////////////////////////////////////////
		if('POST' === $request->getMethod()) {
			if ($request->request->has($product_form->getName())) {
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
		                'تم تعديل المنتج بنجاح'
		            );
					$this->redirect($request->headers->get('referer'));
			    }
	        }
	
	        if ($request->request->has($product_image_form->getName())) {
	            // handle the second form
	            $product_image_form->handleRequest($request);
			    if ($product_image_form->isValid()) {
			    	if($product_image->getFile()){
			    		$product_image->upload();
						$em->persist($product_image);
						$em->flush();
						$this->get('session')->getFlashBag()->add(
			                'success',
			                'تم إضافة بانر بنجاح '
			            );
			    	}
			    }
	        }
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('product' => $product,'vendor' => $product->getVendor(),'product_form' => $product_form->createView(),'product_image_form' => $product_image_form->createView());
    }

	///////////////////////////// FrontEnd Vendor Products Delete Image //////////////////////////////
	/**
     * @Route("/vendor/products/deleteImage/{product}/{image_id}" , name ="front_vendor_products_deleteImge")
     */
    public function deleteFrontVendorProductsImageAction($product,$image_id)
    {
    	$product = $this->getDoctrine()->getManager()->getRepository(get_class(new Product()))->findOneBy(array('id' => $product_id));
    	if (!$this->isAuthenticated($product->getVendor())) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$url = $this->generateUrl(
            'front_editVendor_products_edit',
            array('product_id' => $product)
        );
		$image = $this->getDoctrine()->getManager()->getRepository(get_class(new ProductImage()))->findOneBy(array('id' => $image_id));
		if (is_file($image->getAbsolutePath())) {
			unlink($image->getAbsolutePath());
		}
		$em = $this->getDoctrine()->getManager();
		$em->remove($image);
		$em->flush();
		
		return $this->redirect($url);
    }
	
	////////////////// new Product /////////////////////////////////////
	/**
     * @Route("editVendor/{vendor}/products/new" , name ="front_editVendor_products_new")
	 * @Template("DesoukOnlineMallBundle:Front:User/editVendor_products_new.html.twig")
     */
    public function editVendorProductsNewAction($vendor,Request $request)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($product->getVendor())) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$product = new Product();
		$product->setVendor($vendor);
		$product->setEnabled(true);
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Product Form /////////////////////////////////////////
	    $product_form = $this->get('form.factory')->createNamedBuilder('ProductForm', 'form', $product, array())
			->add('name',null,array('label' => 'الاسم'))
			->add('description','ckeditor',array('label' => 'الوصف و البيانات'))
			->add('code',null,array('label' => 'كود المنتج'))
			->add('price',null,array('label' => 'السعر'))
			->add('vendorProductCategory',null,array('label' => 'القسم','choices'   =>$product->getVendor()->getVendorProductCategories()))
			->add('isInHome',null,array('label' => 'الظهور فى الصفحة الرئيسية للمحل','required'  => false,))
			->add('file', 'file', array('required' => false,'label'=>'الصورة الرئيسية'))
			->add('save', 'submit', array('label' => 'إضافة المنتج'));
		$product_form = $product_form->getForm();
		
		
		////////////////////////////////////////////////////////////////////////////////////
        $product_form->handleRequest($request);
	    if ($product_form->isValid()) {
	    	if($product->getFile()){
	    		$product->upload();
	    	}
	    	$em->persist($product);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
                'success',
                'تم إضافة المنتج بنجاح'
            );
			return $this->redirect($this->generateUrl('front_editVendor_products_edit', array('product_id' => $product->getId())));
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('vendor' => $vendor,'product_form' => $product_form->createView());
    }

	///////////////////////////// FrontEnd Vendor Delete product //////////////////////////////
	/**
     * @Route("/vendor/deleteProduct/{vendor}/{product_id}" , name ="front_vendor_deleteProduct")
     */
    public function deleteFrontVendorProductAction($vendor,$product_id)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($product->getVendor())) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$url = $this->generateUrl(
            'front_editVendor_products',
            array('vendor' => $vendor)
        );
		$product = $this->getDoctrine()->getManager()->getRepository(get_class(new Product()))->findOneBy(array('id' => $product_id));
		$em = $this->getDoctrine()->getManager();
		$em->remove($product);
		$em->flush();
		
		return $this->redirect($url);
    }
	
	////////////////// Articles /////////////////////////////////////
	/**
     * @Route("editVendor/articles/{vendor}" , name ="front_editVendor_articles")
	 * @Template("DesoukOnlineMallBundle:Front:User/editVendor_articles.html.twig")
     */
    public function editVendorArticlesAction($vendor ,Request $request)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($product->getVendor())) {
			return $this->redirect($this->generateUrl('home'));
		}
        $paginator = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $vendor->getArticles(),
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return array('vendor' => $vendor,'articles' => $articles);
    }
    
    ////////////////// Edit article /////////////////////////////////////
	/**
     * @Route("editVendor/articles/edit/{article_id}" , name ="front_editVendor_articles_edit")
	 * @Template("DesoukOnlineMallBundle:Front:User/editVendor_articles_edit.html.twig")
     */
    public function editVendorArticlesEditAction($article_id ,Request $request)
    {
    	$article = $this->getDoctrine()->getManager()->getRepository(get_class(new Article()))->findOneById($article_id);
    	if (!$this->isAuthenticated($article->getVendor())) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Product Form /////////////////////////////////////////
	    $article_form = $this->get('form.factory')->createNamedBuilder('ArticleForm', 'form', $article, array())
			->add('title',null,array('label' => 'عنوان المقال'))
			->add('description','ckeditor',array('label' => 'الوصف '))
			->add('save', 'submit', array('label' => 'تعديل المقال'));
		$article_form = $article_form->getForm();
		
		
		////////////////////////////////////////////////////////////////////////////////////
        $article_form->handleRequest($request);
	    if ($article_form->isValid()) {
	    	$em->persist($article);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
                'success',
                'تم تعديل المقال بنجاح'
            );
			$this->redirect($request->headers->get('referer'));
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('article' => $article,'vendor' => $article->getVendor(),'article_form' => $article_form->createView());
    }

	////////////////// new Article /////////////////////////////////////
	/**
     * @Route("editVendor/{vendor}/articles/new" , name ="front_editVendor_articles_new")
	 * @Template("DesoukOnlineMallBundle:Front:User/editVendor_articles_new.html.twig")
     */
    public function editVendorArticlesNewAction($vendor,Request $request)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($vendor)) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$article = new Article();
		$article->setVendor($vendor);
		$article->setEnabled(true);
    	$em = $this->getDoctrine()->getManager();
		/////////////////////////// Article Form /////////////////////////////////////////
	     $article_form = $this->get('form.factory')->createNamedBuilder('ArticleForm', 'form', $article, array())
			->add('title',null,array('label' => 'عنوان المقال'))
			->add('description','ckeditor',array('label' => 'الوصف '))
			->add('save', 'submit', array('label' => 'إضافة المقال'));
		$article_form = $article_form->getForm();
		
		
		////////////////////////////////////////////////////////////////////////////////////
        $article_form->handleRequest($request);
	    if ($article_form->isValid()) {
	    	$em->persist($article);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
                'success',
                'تم إضافة المقال بنجاح'
            );
			return $this->redirect($this->generateUrl('front_editVendor_articles_edit', array('article_id' => $article->getId())));
	    }
		/////////////////////////////////////////////////////////////////////////////////////
		
	    
        return array('vendor' => $vendor,'article_form' => $article_form->createView());
    }

	///////////////////////////// FrontEnd Vendor Delete article //////////////////////////////
	/**
     * @Route("/vendor/deleteArticle/{vendor}/{article_id}" , name ="front_vendor_deleteArticle")
     */
    public function deleteFrontVendorArticleAction($vendor,$article_id)
    {
    	$vendor = $this->getDoctrine()->getManager()->getRepository(get_class(new Vendor()))->findOneById($vendor);
    	if (!$this->isAuthenticated($product->getVendor())) {
			return $this->redirect($this->generateUrl('home'));
		}
    	$url = $this->generateUrl(
            'front_editVendor_products',
            array('vendor' => $vendor)
        );
		$article = $this->getDoctrine()->getManager()->getRepository(get_class(new Article()))->findOneBy(array('id' => $article_id));
		$em = $this->getDoctrine()->getManager();
		$em->remove($article);
		$em->flush();
		
		return $this->redirect($url);
    }
	
	////////////////////// Check Authentication ////////////////////////////////////////////
	protected function isAuthenticated($vendor)
    {
    	$authenticated = false;
    	$securityContext = $this->container->get('security.context');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
		    $user= $securityContext->getToken()->getUser();
			if($user->getId() == $vendor->getUser()->getId())
			{
				$authenticated = true;
			}
		}
		
		return $authenticated;
    }
}
