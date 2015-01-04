<?php

namespace DesoukOnline\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleHasCategory
 *
 * @ORM\Table(name="article_has_category")
 * @ORM\Entity(repositoryClass="DesoukOnline\ArticleBundle\Entity\ArticleHasCategoryRepository")
 */
class ArticleHasCategory
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
     *  @ORM\ManyToOne(targetEntity="DesoukOnline\ArticleBundle\Entity\Article", inversedBy="article_category", cascade={"all"})
     *  @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected $id_article;

    /**
     *  @ORM\ManyToOne(targetEntity="DesoukOnline\ArticleBundle\Entity\Category", inversedBy="article_category", cascade={"all"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $id_category;

    public function __construct() {

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
     * @param mixed $id_article
     */
    public function setIdArticle($id_article)
    {
        $this->id_article = $id_article;
    }

    /**
     * @return mixed
     */
    public function getIdArticle()
    {
        return $this->id_article;
    }

    /**
     * @param mixed $id_category
     */
    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;
    }

    /**
     * @return mixed
     */
    public function getIdCategory()
    {
        return $this->id_category;
    }


}