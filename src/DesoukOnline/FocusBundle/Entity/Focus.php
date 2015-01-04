<?php

namespace DesoukOnline\FocusBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Focus
 *
 * @ORM\Table(name="focus")
 * @ORM\Entity(repositoryClass="DesoukOnline\FocusBundle\Entity\FocusRepository")
 */
class Focus
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
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $image;


    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", options={"default":1})
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="DesoukOnline\FocusBundle\Entity\Link", mappedBy="focus" , cascade={"All"})
     */
    protected $links;


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
     * Set title
     *
     * @param string $title
     * @return Focus
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Focus
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Focus
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


    /**
     * @param mixed $links
     */
    public function setLinks($links)
    {
        $this->links = new ArrayCollection();

        foreach ($links as $field) {
            $this->addLinks($field);
        }
    }

    /**
     * @return mixed
     */
    public function getLinks()
    {
        return $this->links;
    }




    /**
     * Add page_image
     *
     * @param ProductHasCategory $categoryProduct
     * @return Page
     */
    public function addLinks($link)
    {
        $link->setFocus($this);
        $this->links[] = $link;

        return $this;
    }

    /**
     * Remove page_image
     *
     * @param ProductHasCategory $categoryProduct
     */
    public function removeLinks($links)
    {
        $this->links->removeElement($links);
    }

    public function __toString()
    {
        if (!$this->getTitle())
            return '';
        return $this->getTitle();

    }

}
