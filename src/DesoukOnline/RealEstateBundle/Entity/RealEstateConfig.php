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



}
