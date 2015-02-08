<?php

namespace DesoukOnline\MallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * News
 *
 * @ORM\Table(name="vendor")
 * @ORM\Entity
 */
class Vendor
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string" , length=255)
     */
    private $telephone;


    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string" , length=255)
     */
    private $facebook;


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string" , length=255)
     */
    private $email;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User" , cascade={"all"},inversedBy="vendors" )
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Category" , cascade={"all"},inversedBy="vendors" )
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="DesoukOnline\MallBundle\Entity\VendorProductCategory", mappedBy="vendor", cascade={ "all"}, orphanRemoval=true)
     */
    protected $vendorProductCategories;
	
	/**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="vendor", cascade={ "all"}, orphanRemoval=true)
     */
    protected $products;

    /**
     * @ORM\OneToMany(targetEntity="DesoukOnline\MallBundle\Entity\Article", mappedBy="vendor", cascade={ "all"}, orphanRemoval=true)
     */
    protected $articles;


    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime")
     */
    private $expiredAt;

    //////////////////////////////// Images //////////////////////////////////////////////
    /**
     * @ORM\OneToMany(targetEntity="VendorImage", mappedBy="vendor" ,cascade="persist")
     */
    protected $images;

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = new ArrayCollection();
        foreach ($images as $field) {
            $this->addImage($field);
        }
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    public function addImage($field)
    {
        $field->setVendor($this);

        $this->images[] = $field;

    }

    public function removeImages($fields)
    {
        $this->getImages()->removeElement($fields);
    }
    //////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////  Image Field ////////////////////////////////////////
    /**
     * Image path
     *
     * @var string
     *
     * @ORM\Column(type="text", length=255, nullable=false)
     */
    protected $path;
    /**
     * Image file
     *
     * @var File
     *
     * @Assert\File(
     *     maxSize = "512k",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 512KB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    protected $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Sets path.
     *
     */
    public function setPath($path = null)
    {
        $this->path = $path;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : '/' . $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/vendor';
    }


    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }
        if (is_file($this->getAbsolutePath())) {
            unlink($this->getAbsolutePath());
        }

        $filename = sha1(uniqid(mt_rand(), true));
        $this->path = $filename . '.' . $this->file->guessExtension();


        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and target filename as params
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        // set the path property to the filename where you've saved the file
        //$this->filename = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * Called before entity removal
     *
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////


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
     * @return string
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param string $enabled
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
     * @return \DateTime
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;
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

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }


    /**
     * @param mixed $objects
     */
    public function setVendorProductCategories($objects)
    {
        $this->vendorProductCategories = new ArrayCollection();
        foreach ($objects as $object) {
            $object->setVendor($this);
            $this->addVendorProductCategories($object);
        }
    }

    public function addVendorProductCategories($object)
    {
        $this->vendors[] = $object;
        return $this;
    }

    /**
     * Remove Menu
     *
     * @param StudentSessions $object
     */
    public function removeVendorProductCategories($object)
    {
        $this->vendorProductCategories->removeElement($object);
    }


    /**
     * @return mixed
     */
    public function getVendorProductCategories()
    {
        return $this->vendorProductCategories;
    }


    /**
     * @param mixed $objects
     */
    public function setArticles($objects)
    {
        $this->articles = new ArrayCollection();
        foreach ($objects as $object) {
            $object->setVendor($this);
            $this->addArticles($object);
        }
    }

    public function addArticles($object)
    {
        $this->articles[] = $object;
        return $this;
    }

    /**
     * Remove Menu
     *
     * @param StudentSessions $object
     */
    public function removeArticles($object)
    {
        $this->articles->removeElement($object);
    }


    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }


    /**
     * @return string
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * @param string $banners
     */
    public function setBanners($banners)
    {
        $this->banners = $banners;
    }

    function __toString()
    {
        if ($this->getTitle()) return $this->getTitle();
        return '';
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vendorProductCategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Add vendorProductCategories
     *
     * @param \DesoukOnline\MallBundle\Entity\VendorProductCategory $vendorProductCategories
     * @return Vendor
     */
    public function addVendorProductCategory(\DesoukOnline\MallBundle\Entity\VendorProductCategory $vendorProductCategories)
    {
        $this->vendorProductCategories[] = $vendorProductCategories;

        return $this;
    }

    /**
     * Remove vendorProductCategories
     *
     * @param \DesoukOnline\MallBundle\Entity\VendorProductCategory $vendorProductCategories
     */
    public function removeVendorProductCategory(\DesoukOnline\MallBundle\Entity\VendorProductCategory $vendorProductCategories)
    {
        $this->vendorProductCategories->removeElement($vendorProductCategories);
    }

    /**
     * Add products
     *
     * @param \DesoukOnline\MallBundle\Entity\Product $products
     * @return Vendor
     */
    public function addProduct(\DesoukOnline\MallBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \DesoukOnline\MallBundle\Entity\Product $products
     */
    public function removeProduct(\DesoukOnline\MallBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add articles
     *
     * @param \DesoukOnline\MallBundle\Entity\Article $articles
     * @return Vendor
     */
    public function addArticle(\DesoukOnline\MallBundle\Entity\Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \DesoukOnline\MallBundle\Entity\Article $articles
     */
    public function removeArticle(\DesoukOnline\MallBundle\Entity\Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Remove images
     *
     * @param \DesoukOnline\MallBundle\Entity\VendorImage $images
     */
    public function removeImage(\DesoukOnline\MallBundle\Entity\VendorImage $images)
    {
        $this->images->removeElement($images);
    }
}
