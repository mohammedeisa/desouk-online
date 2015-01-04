<?php

namespace DesoukOnline\FocusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Link
 *
 * @ORM\Table(name= "link")
 * @ORM\Entity
 */
class Link
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
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @param string $name
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
        return $this->name;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;



    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="DesoukOnline\FocusBundle\Entity\Focus", inversedBy="links", cascade={"all"})
     * @ORM\JoinColumn(name="focus_id", referencedColumnName="id")
     */
    private $focus;

    /**
     * @param string $focus
     */
    public function setFocus($focus)
    {
        $this->focus = $focus;
        return $this;
    }

    /**
     * @return string
     */
    public function getFocus()
    {
        return $this->focus;
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
     * Set link
     *
     * @param string $link
     * @return Link
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }
}
