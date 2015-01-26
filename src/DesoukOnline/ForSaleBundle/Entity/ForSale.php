<?php

namespace DesoukOnline\ForSaleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * News
 *
 * @ORM\Table(name="for_sale")
 * @ORM\Entity
 */
class ForSale
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
    private $title;

	/**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;
	
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $gallery;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Category" , cascade={"all"},inversedBy="forSaleProperties" )
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

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
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

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
     * @return string
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param string $gallery
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
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
	
	public function __toString()
    {
        return $this->title;
    }
	
	//////////////////////////////// Images //////////////////////////////////////////////
	/**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="forSale" ,cascade="persist")
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
        $field->setForSale($this);

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
	    return 'uploads/forSale';
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
	    if ($file = $this->getAbsolutePath()) {
	        unlink($file); 
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
     * Set summary
     *
     * @param string $summary
     * @return ForSale
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
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
     * Remove images
     *
     * @param \DesoukOnline\ForSaleBundle\Entity\Image $images
     */
    public function removeImage(\DesoukOnline\ForSaleBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }
}
