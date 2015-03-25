<?php

namespace DesoukOnline\RealEstateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * News
 *
 * @ORM\Table(name="real_estate_config")
 * @ORM\Entity
 */
class RealEstateConfig
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
     * @ORM\Column(name="mall_title", type="string", length=255)
     */
    private $realEstateTitle;


    /**
     * @var string
     *
     * @ORM\Column(name="mall_description", type="text")
     */
    private $realEstateDescription;


    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255)
     */
    private $metaTitle;


    /**
     * @var string
     *
     * @ORM\Column(name="meta__description", type="text")
     */
    private $metaDescription;
    
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
    public function getRealEstateTitle()
    {
        return $this->realEstateTitle;
    }

    /**
     * @param string $realEstateTitle
     */
    public function setRealEstateTitle($realEstateTitle)
    {
        $this->realEstateTitle = $realEstateTitle;
    }

    /**
     * @return string
     */
    public function getRealEstateDescription()
    {
        return $this->realEstateDescription;
    }

    /**
     * @param string $realEstateDescription
     */
    public function setRealEstateDescription($realEstateDescription)
    {
        $this->realEstateDescription = $realEstateDescription;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }




}
