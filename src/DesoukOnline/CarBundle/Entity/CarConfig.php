<?php

namespace DesoukOnline\CarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * News
 *
 * @ORM\Table(name="Car_config")
 * @ORM\Entity
 */
class CarConfig
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
     * @ORM\Column(name="car_title", type="string", length=255)
     */
    private $carTitle;


    /**
     * @var string
     *
     * @ORM\Column(name="car_description", type="text")
     */
    private $carDescription;

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
    public function getCarTitle()
    {
        return $this->carTitle;
    }

    /**
     * @param string $carTitle
     */
    public function setCarTitle($carTitle)
    {
        $this->carTitle = $carTitle;
    }

    /**
     * @return string
     */
    public function getCarDescription()
    {
        return $this->carDescription;
    }

    /**
     * @param string $carDescription
     */
    public function setCarDescription($carDescription)
    {
        $this->carDescription = $carDescription;
    }


}
