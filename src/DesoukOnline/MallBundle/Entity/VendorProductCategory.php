<?php

namespace DesoukOnline\MallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * News
 *
 * @ORM\Entity
 * @ORM\Table(name = "vendor_product_category")
 */
class VendorProductCategory
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255 , nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_in_home", type="boolean", nullable=true)
     */
    private $isInHome;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;


    /**
     * @ORM\OneToMany(targetEntity="DesoukOnline\MallBundle\Entity\Product", mappedBy="vendorProductCategory", cascade={ "all"}, orphanRemoval=true)
     */
    protected $products;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="DesoukOnline\MallBundle\Entity\Vendor" , cascade={"all"},inversedBy="vendorProductCategories" )
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $vendor;


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
     * @param mixed $objects
     */
    public function setProducts($objects)
    {
        $this->products = new ArrayCollection();
        foreach ($objects as $object) {
            $object->setVendorProductCategory($this);
            $this->addProducts($object);
        }
    }

    public function addProducts($object)
    {
        $this->products[] = $object;
        return $this;
    }

    /**
     * Remove Menu
     *
     * @param StudentSessions $object
     */
    public function removeProducts($object)
    {
        $this->products->removeElement($object);
    }


    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }


    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }




    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    function __toString()
    {
        if ($this->getTitle())
            return $this->getTitle();
        return '';
    }

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param string $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return boolean
     */
    public function isIsInHome()
    {
        return $this->isInHome;
    }

    /**
     * @param boolean $isInHome
     */
    public function setIsInHome($isInHome)
    {
        $this->isInHome = $isInHome;
    }

}
