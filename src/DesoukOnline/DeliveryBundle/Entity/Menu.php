<?php

namespace DesoukOnline\DeliveryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * News
 *
 * @ORM\Table(name="delivery_menu")
 * @ORM\Entity
 */
class Menu
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
     * @ORM\ManyToOne(targetEntity="DesoukOnline\DeliveryBundle\Entity\Delivery" , cascade={"all"},inversedBy="menus" )
     * @ORM\JoinColumn(name="delivery_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $delivery;

    /**
     * @ORM\OneToMany(targetEntity="DesoukOnline\DeliveryBundle\Entity\MenuItem", mappedBy="menu", cascade={ "all"}, orphanRemoval=true)
     */
    private $menuItems;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media" , cascade={"remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $image;

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
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * @param string $delivery
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;
    }

    /**
     * @param mixed $objects
     */
    public function setMenuItems($objects)
    {
        $this->menuItems = new ArrayCollection();
        foreach ($objects as $object) {
            $object->setMenu($this);
            $this->addMenuItems($object);
        }
    }

    public function addMenuItems($object)
    {
        $this->menuItems[] = $object;
        return $this;
    }

    /**
     * Remove Menu
     *
     * @param StudentSessions $object
     */
    public function removeMenuItems($object)
    {
        $this->menuItems->removeElement($object);
    }

    /**
     * @return mixed
     */
    public function getMenuItems()
    {
        return $this->menuItems;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    function __toString()
    {
        return ($this->getTitle()) ? $this->getTitle() : '';
    }


}
