<?php

namespace DesoukOnline\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="DesoukOnline\ProductBundle\Entity\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */

    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="name_ar", type="string", length=255, nullable=true)
     */

    private $nameAr;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="description_ar", type="string", length=255, nullable=true)
     */
    private $descriptionAr;
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", options={"default":1})
     */
    private $enabled;


    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Menu
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Menu
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     */
    private $banner;

    ///////////// add Categories to the product
    /**
     * @ORM\OneToMany(targetEntity="ProductHasCategory", mappedBy="id_product" , cascade={"all"})
     */
    protected $product_category;

    /**
     * Add page_image
     *
     * @param ProductHasCategory $productCategory
     * @return Page
     */
    public function addProductCategory($productCategory)
    {
        $this->product_category[] = $productCategory;
        return $this;
    }

    /**
     * Remove page_image
     *
     * @param ProductHasCategory $productCategory
     */
    public function removeProductCategory($productCategory)
    {
        $this->product_category->removeElement($productCategory);
    }

    /**
     * Get page_image
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductCategory()
    {
        return $this->product_category;
    }

    public function setProductCategory($productCategorys)
    {
        $this->product_category = new ArrayCollection();

        foreach ($productCategorys as $productCategory) {
            $productCategory->setIdProduct($this);
            $this->addProductCategory($productCategory);
        }
    }

/////////add gallary to the product////////////////////

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $gallery;

    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return string
     */
    public function getGallery()
    {
        return $this->gallery;
    }

//////////////////////////////////////////////

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Tag
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
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
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @ORM\PostPersist
     * * @ORM\PrePersist
     * @ORM\PostUpdate
     */
    public function prePersist()
    {
        $this->slug = str_replace(" ", "_", strtolower($this->name)) . '_' . $this->id;
    }

    /**
     * @param string $banner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;
    }

    /**
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param string $descriptionAr
     */
    public function setDescriptionAr($descriptionAr)
    {
        $this->descriptionAr = $descriptionAr;
    }

    /**
     * @return string
     */
    public function getDescriptionAr()
    {
        return $this->descriptionAr;
    }

    /**
     * @param string $nameAr
     */
    public function setNameAr($nameAr)
    {
        $this->nameAr = $nameAr;
    }

    /**
     * @return string
     */
    public function getNameAr()
    {
        return $this->nameAr;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

}
