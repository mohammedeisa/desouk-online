<?php

namespace DesoukOnline\MallBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * News
 *
 * @ORM\Table(name="mall_config")
 * @ORM\Entity
 */
class MallConfig
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
    private $mallTitle;


    /**
     * @var string
     *
     * @ORM\Column(name="mall_description", type="text")
     */
    private $mallDescription;

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
    public function getMallDescription()
    {
        return $this->mallDescription;
    }

    /**
     * @param string $mallDescription
     */
    public function setMallDescription($mallDescription)
    {
        $this->mallDescription = $mallDescription;
    }

    /**
     * @return string
     */
    public function getMallTitle()
    {
        return $this->mallTitle;
    }

    /**
     * @param string $mallTitle
     */
    public function setMallTitle($mallTitle)
    {
        $this->mallTitle = $mallTitle;
    }

}
