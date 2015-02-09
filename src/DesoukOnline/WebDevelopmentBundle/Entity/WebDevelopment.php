<?php

namespace DesoukOnline\WebDevelopmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table(name="web_development")
 * @ORM\Entity
 */
class WebDevelopment
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
     * @ORM\Column(name="web_development_title", type="string", length=255)
     */
    private $webDevelopmentTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="web_development_description", type="string", length=255)
     */
    private $webDevelopmentDescription;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media" , cascade={"remove"})
     * @ORM\JoinColumn(name="web_development_banner", referencedColumnName="id", onDelete="SET NULL")
     */
    private $webDevelopmentBanner;

    /**
     * @var string
     *
     * @ORM\Column(name="hosting_title", type="string", length=255)
     */
    private $hostingTitle;
    /**
     * @var string
     *
     * @ORM\Column(name="hosting_description", type="string", length=255)
     */
    private $hostingDescription;


    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media" , cascade={"remove"})
     * @ORM\JoinColumn(name="hosting_banner", referencedColumnName="id", onDelete="SET NULL")
     */
    private $hostingBanner;

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
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Gallery")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $banners;

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
    public function getWebDevelopmentTitle()
    {
        return $this->webDevelopmentTitle;
    }

    /**
     * @param string $webDevelopmentTitle
     */
    public function setWebDevelopmentTitle($webDevelopmentTitle)
    {
        $this->webDevelopmentTitle = $webDevelopmentTitle;
    }

    /**
     * @return string
     */
    public function getWebDevelopmentDescription()
    {
        return $this->webDevelopmentDescription;
    }

    /**
     * @param string $webDevelopmentDescription
     */
    public function setWebDevelopmentDescription($webDevelopmentDescription)
    {
        $this->webDevelopmentDescription = $webDevelopmentDescription;
    }

    /**
     * @return string
     */
    public function getHostingTitle()
    {
        return $this->hostingTitle;
    }

    /**
     * @param string $hostingTitle
     */
    public function setHostingTitle($hostingTitle)
    {
        $this->hostingTitle = $hostingTitle;
    }

    /**
     * @return string
     */
    public function getHostingDescription()
    {
        return $this->hostingDescription;
    }

    /**
     * @param string $hostingDescription
     */
    public function setHostingDescription($hostingDescription)
    {
        $this->hostingDescription = $hostingDescription;
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

    /**
     * @return string
     */
    public function getWebDevelopmentBanner()
    {
        return $this->webDevelopmentBanner;
    }

    /**
     * @param string $webDevelopmentBanner
     */
    public function setWebDevelopmentBanner($webDevelopmentBanner)
    {
        $this->webDevelopmentBanner = $webDevelopmentBanner;
    }

    /**
     * @return string
     */
    public function getHostingBanner()
    {
        return $this->hostingBanner;
    }

    /**
     * @param string $hostingBanner
     */
    public function setHostingBanner($hostingBanner)
    {
        $this->hostingBanner = $hostingBanner;
    }

}
