<?php

namespace DesoukOnline\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations


/**
 * @ORM\Entity
 * @ORM\Table(name="product_category")
 */
class ProductHasCategory {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *  @ORM\ManyToOne(targetEntity="Product", inversedBy="product_category", cascade={"all"})
     */
    protected $id_product;

    /**
     *  @ORM\ManyToOne(targetEntity="Category", inversedBy="category_product", cascade={"all"})
     */
    private $id_category;

    public function __construct() {

    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id_page
     *
     * @param Product $id_product
     * @return PageHasMedia
     */
    public function setIdProduct( $id_product = null)
    {
        $this->id_product = $id_product;

        return $this;
    }

    /**
     * Get id_page
     *
     * @return  Product
     */
    public function getIdProduct()
    {
        return $this->id_product;
    }

    /**
     * Set id_media
     *
     * @param Category $id_category
     * @return PageHasMedia
     */
    public function setIdCategory( $id_category = null)
    {
        $this->id_category = $id_category;

        return $this;
    }

    /**
     * Get id_media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getIdCategory()
    {
        return $this->id_category;
    }
}