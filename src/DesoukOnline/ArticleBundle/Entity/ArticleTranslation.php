<?php

namespace DesoukOnline\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;



/**
 * @ORM\Entity
 * @ORM\Table(name="article_translations")
 *
 */

class ArticleTranslation extends AbstractPersonalTranslation
{

}
