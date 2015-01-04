<?php

namespace DesoukOnline\BannerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BannerTranslations
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DesoukOnline\BannerBundle\Entity\BannerTranslationsRepository")
 */
class BannerTranslations
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
     * @ORM\Column(name="locale", type="string", length=255)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="field", type="string", length=255)
     */
    private $field;


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
     * Set locale
     *
     * @param string $locale
     * @return BannerTranslations
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string 
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return BannerTranslations
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set field
     *
     * @param string $field
     * @return BannerTranslations
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return string 
     */
    public function getField()
    {
        return $this->field;
    }

/**
     * @ORM\ManyToOne(targetEntity="Banner", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id")
     */
protected $Banner;

}
