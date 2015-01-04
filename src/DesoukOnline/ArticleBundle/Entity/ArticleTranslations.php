<?php

namespace DesoukOnline\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleTranslations
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DesoukOnline\ArticleBundle\Entity\ArticleTranslationsRepository")
 */
class ArticleTranslations
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
     * @return ArticleTranslations
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
     * @return ArticleTranslations
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
     * @return ArticleTranslations
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @param mixed $Article
     */
    public function setArticle($Article)
    {
        $this->Article = $Article;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->Article;
    }

    /**
     * @param mixed $object_id
     */
    public function setObjectId($object_id)
    {
        $this->object_id = $object_id;
    }

    /**
     * @return mixed
     */
    public function getObjectId()
    {
        return $this->object_id;
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
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="translations", cascade={"persist"})
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id")
     */
    private $object_id;



protected $Article;

     function __toString(){
        return "DesoukOnlineArticleBundle:ArticleTranslations";
    }

}
