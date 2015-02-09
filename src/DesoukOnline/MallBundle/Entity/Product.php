<?php

namespace DesoukOnline\MallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Product
 *
 * @ORM\Table(name="vendor_product")
 * @ORM\Entity(repositoryClass="DesoukOnline\MallBundle\Entity\ProductRepository")
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", options={"default":1})
     */
    private $enabled;


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_in_home", type="boolean", options={"default":1})
     */
    private $isInHome;

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
     * @ORM\ManyToOne(targetEntity="DesoukOnline\MallBundle\Entity\VendorProductCategory" , cascade={"all"},inversedBy="products" )
     * @ORM\JoinColumn(name="vendor_product_category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $vendorProductCategory;
	
	/**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Vendor" , cascade={"all"},inversedBy="products" )
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $vendor;


    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;


//////////////////////////////////////////////
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

    /**
     * @return string
     */
    public function getVendorProductCategory()
    {
        return $this->vendorProductCategory;
    }

    /**
     * @param string $vendorProductCategory
     */
    public function setVendorProductCategory($vendorProductCategory)
    {
        $this->vendorProductCategory = $vendorProductCategory;
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
	
	
	//////////////////////////////// Images //////////////////////////////////////////////
	/**
     * @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product" ,cascade="persist")
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
        $field->setProduct($this);

        $this->images[] = $field;

    }

    public function removeImages( $fields)
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
		return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
	}
	
	public function getWebPath()
	{
		return null === $this->path ? null : '/'.$this->getUploadDir().'/'.$this->path;
	}
	
	protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
	
	protected function getUploadDir()
	{
		// get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
	    return 'uploads/vendorProduct';
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
        $this->path = $filename.'.'.$this->file->guessExtension();
		
	
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
	    if (is_file($this->getAbsolutePath())) {
	        unlink($this->getAbsolutePath()); 
	    }
	}
	////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get isInHome
     *
     * @return boolean 
     */
    public function getIsInHome()
    {
        return $this->isInHome;
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
     * Set vendor
     *
     * @param \DesoukOnline\MallBundle\Entity\Vendor $vendor
     * @return Product
     */
    public function setVendor(\DesoukOnline\MallBundle\Entity\Vendor $vendor = null)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return \DesoukOnline\MallBundle\Entity\Vendor 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Remove images
     *
     * @param \DesoukOnline\MallBundle\Entity\ProductImage $images
     */
    public function removeImage(\DesoukOnline\MallBundle\Entity\ProductImage $images)
    {
        $this->images->removeElement($images);
    }
}
