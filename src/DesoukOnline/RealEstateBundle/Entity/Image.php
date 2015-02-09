<?php

namespace DesoukOnline\RealEstateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="realestate_image")
 * @ORM\Entity
 */
class Image
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
     * @ORM\ManyToOne(targetEntity="RealEstate", inversedBy="images")
     * @ORM\JoinColumn(name="realestate_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $realestate;
	
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
	    return 'uploads/realestate_gallery';
	}
	
	
	public function upload()
	{
	    // the file property can be empty if the field is not required
	    if (null === $this->getFile()) {
	        return;
	    }
		$file = $this->getAbsolutePath();
		if (file_exists($file)) {
	        unlink($file); 
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
     * Set realestate
     *
     * @param \DesoukOnline\RealEstateBundle\Entity\RealEstate $realestate
     * @return Image
     */
    public function setRealestate(\DesoukOnline\RealEstateBundle\Entity\RealEstate $realestate = null)
    {
        $this->realestate = $realestate;

        return $this;
    }

    /**
     * Get realestate
     *
     * @return \DesoukOnline\RealEstateBundle\Entity\RealEstate 
     */
    public function getRealestate()
    {
        return $this->realestate;
    }
}
