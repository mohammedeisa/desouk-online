<?php

namespace DesoukOnline\ProductBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Category
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name = "category")
 * @ORM\Entity(repositoryClass="DesoukOnline\ProductBundle\Entity\CategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Category
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
     * @ORM\OneToMany(targetEntity="ProductHasCategory", mappedBy="id_category" , cascade={"all"})
     */
    protected $category_product;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media" , cascade={"remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="banner_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $banner;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @var integer
     *
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @var integer
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @var integer
     *
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @var integer
     *
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer")
     */
    private $root;

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_ar", type="string", length=255, nullable=true)
     */
    private $nameAr;

    /**
     * @var string
     *
     *
     */
    private $names_hierarchy;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="description_ar", type="string", length=255, nullable=true)
     */
    private $descriptionAr;
     
    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", options={"default":1})
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_elevators", type="boolean", options={"default":0})
     */
    private $isElevators;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_arabic", type="boolean", options={"default":0})
     */
    private $isArabic;

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
     * Set image
     *
     * @param string $title
     * @return image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }



    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Set title
     * @param string $name
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set title
     * @param string $name
     * @return Menu
     */
    public function setNamesHierarchy($names_hierarchy)
    {
        $this->names_hierarchy = $names_hierarchy;
        return $this;
    }
    /**
     * Set description
     * @param string $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set parent
     *
     * @param Category $parent
     * @return Menu
     */
    public function setParent( $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return integer
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set children
     *
     * @param Category $children
     * @return Category
     */
    public function setChildren( $children )
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return integer
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     * @return Menu
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }
    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return Menu
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }
    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return Menu
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return Menu
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get title
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    public function getNamesHierarchy()
    {
        return $this->names_hierarchy;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    public function __toString()
    {
        $space="";
        for ($i=0 ; $i < $this->lvl ; $i++){
            $space = $space."----";
        }
        $this->names_hierarchy = $space.$this->name;
        return  $space.$this->name;
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
     * Add page_image
     *
     * @param ProductHasCategory $categoryProduct
     * @return Page
     */
    public function addCategoryProduct( $categoryProduct)
    {
        $this->category_product[] = $categoryProduct;

        return $this;
    }

    /**
     * Remove page_image
     *
     * @param ProductHasCategory $categoryProduct
     */
    public function removeCategoryProduct( $categoryProduct)
    {
        $this->category_product->removeElement($categoryProduct);
    }

    /**
     * Get page_image
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoryProduct()
    {
        return $this->category_product;
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
     * @param boolean $isElevators
     */
    public function setIsElevators($isElevators)
    {
        $this->isElevators = $isElevators;
    }

    /**
     * @return boolean
     */
    public function getIsElevators()
    {
        return $this->isElevators;
    }

    /**
     * @param boolean $isArabic
     */
    public function setIsArabic($isArabic)
    {
        $this->isArabic = $isArabic;
    }

    /**
     * @return boolean
     */
    public function getIsArabic()
    {
        return $this->isArabic;
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

}
