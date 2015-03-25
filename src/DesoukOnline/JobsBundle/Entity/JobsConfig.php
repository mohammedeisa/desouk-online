<?php

namespace DesoukOnline\JobsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * News
 *
 * @ORM\Table(name="jobs_config")
 * @ORM\Entity
 */
class JobsConfig
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
     * @ORM\Column(name="jobs_title", type="string", length=255)
     */
    private $jobsTitle;


    /**
     * @var string
     *
     * @ORM\Column(name="jobs_description", type="text")
     */
    private $jobsDescription;

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
    public function getJobsTitle()
    {
        return $this->jobsTitle;
    }

    /**
     * @param string $jobsTitle
     */
    public function setJobsTitle($jobsTitle)
    {
        $this->jobsTitle = $jobsTitle;
    }

    /**
     * @return string
     */
    public function getJobsDescription()
    {
        return $this->jobsDescription;
    }

    /**
     * @param string $jobsDescription
     */
    public function setJobsDescription($jobsDescription)
    {
        $this->jobsDescription = $jobsDescription;
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
