<?php

namespace DesoukOnline\ArticleBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Translatable\Translatable;




/**
 * Article
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name = "article")
 * @ORM\Entity(repositoryClass="DesoukOnline\ArticleBundle\Entity\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255, nullable = false)
     */
    protected $name;


    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @ORM\JoinColumn(name="banner_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $banner;

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
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", options={"default":1})
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_intro", type="boolean", options={"default":0})
     */
    private $isIntro;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_featured_content", type="boolean", options={"default":0})
     */
    private $isFeaturedContent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_about_root", type="boolean", options={"default":0})
     */
    private $isAboutRoot;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_about", type="boolean", options={"default":0})
     */
    private $isAbout;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_history", type="boolean", options={"default":0})
     */
    private $isHistory;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_vision", type="boolean", options={"default":0})
     */
    private $isVision;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_philosophy", type="boolean", options={"default":0})
     */
    private $isPhilosophy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_life_at_ultimatrue", type="boolean", options={"default":0})
     */
    private $isLifeAtUltimatrue;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="parent")
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
     */
    private $names_hierarchy;

    /**
     * Set parent
     *
     * @param Article $parent
     * @return Article
     */
    public function setParent($parent = null)
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
     * @param Article $children
     * @return Article
     */
    public function setChildren($children)
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * Set title
     * @param string $name
     * @return Article
     */
    public function setNamesHierarchy($names_hierarchy)
    {
        $this->names_hierarchy = $names_hierarchy;
        return $this;
    }


    public function getNamesHierarchy()
    {
        return $this->names_hierarchy;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        $space = "";
        for ($i = 0; $i < $this->lvl; $i++) {
            $space = $space . "--";
        }
        $this->names_hierarchy = $space . $this->name;
        return $space . $this->name;
    }

    public function getFrontName()
    {
        return $this->name;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

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


    public function __toString()
    {
        $space = "";
        for ($i = 0; $i < $this->lvl; $i++) {
            $space = $space . "--";
        }
        $this->names_hierarchy = $space . $this->name;
        return $space . $this->name;
    }


    /**
     * @ORM\PostPersist
     * * @ORM\PrePersist
     * @ORM\PostUpdate
     */
    public function postPersist()
    {
        $this->slug = str_replace(" ", "_", strtolower($this->name)) . '_' . $this->id;
    }



    /**
     * @param boolean $isFeaturedContent
     */
    public function setIsFeaturedContent($isFeaturedContent)
    {
        $this->isFeaturedContent = $isFeaturedContent;
    }

    /**
     * @return boolean
     */
    public function getIsFeaturedContent()
    {
        return $this->isFeaturedContent;
    }

    /**
     * @param boolean $isIntro
     */
    public function setIsIntro($isIntro)
    {
        $this->isIntro = $isIntro;
    }

    /**
     * @return boolean
     */
    public function getIsIntro()
    {
        return $this->isIntro;
    }

    /**
     * @param boolean $isAboutRoot
     */
    public function setIsAboutRoot($isAboutRoot)
    {
        $this->isAboutRoot = $isAboutRoot;
    }

    /**
     * @return boolean
     */
    public function getIsAboutRoot()
    {
        return $this->isAboutRoot;
    }

    /**
     * @param boolean $isHistory
     */
    public function setIsHistory($isHistory)
    {
        $this->isHistory = $isHistory;
    }

    /**
     * @return boolean
     */
    public function getIsHistory()
    {
        return $this->isHistory;
    }

    /**
     * @param boolean $isPhilosophy
     */
    public function setIsPhilosophy($isPhilosophy)
    {
        $this->isPhilosophy = $isPhilosophy;
    }

    /**
     * @return boolean
     */
    public function getIsPhilosophy()
    {
        return $this->isPhilosophy;
    }

    /**
     * @param boolean $isVision
     */
    public function setIsVision($isVision)
    {
        $this->isVision = $isVision;
    }

    /**
     * @return boolean
     */
    public function getIsVision()
    {
        return $this->isVision;
    }

    /**
     * @param boolean $isLifeAtUltimatrue
     */
    public function setIsLifeAtUltimatrue($isLifeAtUltimatrue)
    {
        $this->isLifeAtUltimatrue = $isLifeAtUltimatrue;
    }

    /**
     * @return boolean
     */
    public function getIsLifeAtUltimatrue()
    {
        return $this->isLifeAtUltimatrue;
    }

    /**
     * @param boolean $isAbout
     */
    public function setIsAbout($isAbout)
    {
        $this->isAbout = $isAbout;
    }

    /**
     * @return boolean
     */
    public function getIsAbout()
    {
        return $this->isAbout;
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

}
