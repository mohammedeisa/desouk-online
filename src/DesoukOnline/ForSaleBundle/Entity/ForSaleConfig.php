<?php

namespace DesoukOnline\ForSaleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * News
 *
 * @ORM\Table(name="for_sale_config")
 * @ORM\Entity
 */
class ForSaleConfig
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
     * @ORM\Column(name="for_sale_title", type="string", length=255)
     */
    private $forSaleTitle;


    /**
     * @var string
     *
     * @ORM\Column(name="for_sale_description", type="text")
     */
    private $forSaleDescription;

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
    public function getForSaleTitle()
    {
        return $this->forSaleTitle;
    }

    /**
     * @param string $forSaleTitle
     */
    public function setForSaleTitle($forSaleTitle)
    {
        $this->forSaleTitle = $forSaleTitle;
    }

    /**
     * @return string
     */
    public function getForSaleDescription()
    {
        return $this->forSaleDescription;
    }

    /**
     * @param string $forSaleDescription
     */
    public function setForSaleDescription($forSaleDescription)
    {
        $this->forSaleDescription = $forSaleDescription;
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
