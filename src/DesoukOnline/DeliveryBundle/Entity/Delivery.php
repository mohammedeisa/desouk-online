<?php

namespace DesoukOnline\DeliveryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * News
 *
 * @ORM\Table(name="delivery")
 * @ORM\Entity
 */
class Delivery
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
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime")
     */
    private $expiredAt;

    ////////////////////////////////  Image Field ////////////////////////////////////////
    /**
     * Image path
     *
     * @var string
     *
     * @ORM\Column(type="text", length=255, nullable=true)
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
        return 'uploads/delivery';
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
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User" , cascade={"all"},inversedBy="deliveries" )
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="DesoukOnline\DeliveryBundle\Entity\Menu", mappedBy="delivery", cascade={ "all"}, orphanRemoval=true)
     */
    protected $menus;


    /**
     * @var string
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;
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
     * @return string
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param string $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
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
     * @param mixed $objects
     */
    public function setMenus($objects)
    {
        $this->menus = new ArrayCollection();
        foreach ($objects as $object) {
            $object->setVendor($this);
            $this->addMenus($object);
        }
    }

    public function addMenus($object)
    {
        $this->menus[] = $object;
        return $this;
    }

    /**
     * Remove Menu
     *
     * @param StudentSessions $object
     */
    public function removeMenus($object)
    {
        $this->menus->removeElement($object);
    }


    /**
     * @return mixed
     */
    public function getMenus()
    {
        return $this->menus;
    }

    function __toString()
    {
        return ($this->getTitle()) ? $this->getTitle() : '';
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

}
