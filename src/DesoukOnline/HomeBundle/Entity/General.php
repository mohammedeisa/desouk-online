<?php

namespace DesoukOnline\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * News
 *
 * @ORM\Table(name="general")
 * @ORM\Entity(repositoryClass="DesoukOnline\HomeBundle\Entity\GeneralRepository")
 */
class General
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
     * @ORM\Column(name="general_modules_pre_title", type="string", length=255)
     */
    private $generalModulesPreTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="mall_pre_title", type="string", length=255)
     */
    private $mallPreTitle;


    /**
     * @var string
     *
     * @ORM\Column(name="homepage_meta_description", type="string", length=255)
     */
    private $homepageMetaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="homepage_meta_title", type="text")
     */
    private $homepageMetaDescription;


//    Real Estates
    /**
     * @var string
     *
     * @ORM\Column(name="real_estate_middle_of_title_in_index", type="string", length=255)
     */
    private $realEstateMiddleOfTitleInIndex;


    /**
     * @var string
     *
     * @ORM\Column(name="real_estate_middle_of_title_in_filtered_index", type="string", length=255)
     *
     */
    private $realEstateMiddleOfTitleInFilteredIndex;


    /**
     * @var string
     *
     * @ORM\Column(name="real_estate_middle_of_title_in_show", type="string", length=255)
     */
    private $realEstateMiddleOfTitleInShow;
//    End Real Estates


//    Cars
    /**
     * @var string
     *
     * @ORM\Column(name="car_middle_of_title_in_index", type="string", length=255)
     */
    private $carMiddleOfTitleInIndex;


    /**
     * @var string
     *
     * @ORM\Column(name="car_middle_of_title_in_filtered_index", type="string", length=255)
     *
     */
    private $carMiddleOfTitleInFilteredIndex;


    /**
     * @var string
     *
     * @ORM\Column(name="car_middle_of_title_in_show", type="string", length=255)
     */
    private $carMiddleOfTitleInShow;
//    End cars


//    Jobs
    /**
     * @var string
     *
     * @ORM\Column(name="Job_middle_of_title_in_index", type="string", length=255)
     */
    private $jobMiddleOfTitleInIndex;


    /**
     * @var string
     *
     * @ORM\Column(name="job_middle_of_title_in_filtered_index", type="string", length=255)
     *
     */
    private $jobMiddleOfTitleInFilteredIndex;


    /**
     * @var string
     *
     * @ORM\Column(name="job_middle_of_title_in_show", type="string", length=255)
     */
    private $jobMiddleOfTitleInShow;
//    End Jobs

//    Real Estates
    /**
     * @var string
     *
     * @ORM\Column(name="for_sate_middle_of_title_in_index", type="string", length=255)
     */
    private $forSaleMiddleOfTitleInIndex;


    /**
     * @var string
     *
     * @ORM\Column(name="for_sate_middle_of_title_in_filtered_index", type="string", length=255)
     *
     */
    private $forSaleMiddleOfTitleInFilteredIndex;


    /**
     * @var string
     *
     * @ORM\Column(name="for_sate_middle_of_title_in_show", type="string", length=255)
     */
    private $forSaleMiddleOfTitleInShow;

//    End for sale


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
    public function getGeneralModulesPreTitle()
    {
        return $this->generalModulesPreTitle;
    }

    /**
     * @param string $generalModulesPreTitle
     */
    public function setGeneralModulesPreTitle($generalModulesPreTitle)
    {
        $this->generalModulesPreTitle = $generalModulesPreTitle;
    }

    /**
     * @return string
     */
    public function getRealEstateMiddleOfTitleInIndex()
    {
        return $this->realEstateMiddleOfTitleInIndex;
    }

    /**
     * @param string $realEstateMiddleOfTitleInIndex
     */
    public function setRealEstateMiddleOfTitleInIndex($realEstateMiddleOfTitleInIndex)
    {
        $this->realEstateMiddleOfTitleInIndex = $realEstateMiddleOfTitleInIndex;
    }

    /**
     * @return string
     */
    public function getRealEstateMiddleOfTitleInFilteredIndex()
    {
        return $this->realEstateMiddleOfTitleInFilteredIndex;
    }

    /**
     * @param string $realEstateMiddleOfTitleInFilteredIndex
     */
    public function setRealEstateMiddleOfTitleInFilteredIndex($realEstateMiddleOfTitleInFilteredIndex)
    {
        $this->realEstateMiddleOfTitleInFilteredIndex = $realEstateMiddleOfTitleInFilteredIndex;
    }

    /**
     * @return string
     */
    public function getRealEstateMiddleOfTitleInShow()
    {
        return $this->realEstateMiddleOfTitleInShow;
    }

    /**
     * @param string $realEstateMiddleOfTitleInShow
     */
    public function setRealEstateMiddleOfTitleInShow($realEstateMiddleOfTitleInShow)
    {
        $this->realEstateMiddleOfTitleInShow = $realEstateMiddleOfTitleInShow;
    }

    /**
     * @return string
     */
    public function getCarMiddleOfTitleInIndex()
    {
        return $this->carMiddleOfTitleInIndex;
    }

    /**
     * @param string $carMiddleOfTitleInIndex
     */
    public function setCarMiddleOfTitleInIndex($carMiddleOfTitleInIndex)
    {
        $this->carMiddleOfTitleInIndex = $carMiddleOfTitleInIndex;
    }

    /**
     * @return string
     */
    public function getCarMiddleOfTitleInFilteredIndex()
    {
        return $this->carMiddleOfTitleInFilteredIndex;
    }

    /**
     * @param string $carMiddleOfTitleInFilteredIndex
     */
    public function setCarMiddleOfTitleInFilteredIndex($carMiddleOfTitleInFilteredIndex)
    {
        $this->carMiddleOfTitleInFilteredIndex = $carMiddleOfTitleInFilteredIndex;
    }

    /**
     * @return string
     */
    public function getCarMiddleOfTitleInShow()
    {
        return $this->carMiddleOfTitleInShow;
    }

    /**
     * @param string $carMiddleOfTitleInShow
     */
    public function setCarMiddleOfTitleInShow($carMiddleOfTitleInShow)
    {
        $this->carMiddleOfTitleInShow = $carMiddleOfTitleInShow;
    }

    /**
     * @return string
     */
    public function getJobMiddleOfTitleInIndex()
    {
        return $this->jobMiddleOfTitleInIndex;
    }

    /**
     * @param string $jobMiddleOfTitleInIndex
     */
    public function setJobMiddleOfTitleInIndex($jobMiddleOfTitleInIndex)
    {
        $this->jobMiddleOfTitleInIndex = $jobMiddleOfTitleInIndex;
    }

    /**
     * @return string
     */
    public function getJobMiddleOfTitleInFilteredIndex()
    {
        return $this->jobMiddleOfTitleInFilteredIndex;
    }

    /**
     * @param string $jobMiddleOfTitleInFilteredIndex
     */
    public function setJobMiddleOfTitleInFilteredIndex($jobMiddleOfTitleInFilteredIndex)
    {
        $this->jobMiddleOfTitleInFilteredIndex = $jobMiddleOfTitleInFilteredIndex;
    }

    /**
     * @return string
     */
    public function getJobMiddleOfTitleInShow()
    {
        return $this->jobMiddleOfTitleInShow;
    }

    /**
     * @param string $jobMiddleOfTitleInShow
     */
    public function setJobMiddleOfTitleInShow($jobMiddleOfTitleInShow)
    {
        $this->jobMiddleOfTitleInShow = $jobMiddleOfTitleInShow;
    }

    /**
     * @return string
     */
    public function getForSaleMiddleOfTitleInIndex()
    {
        return $this->forSaleMiddleOfTitleInIndex;
    }

    /**
     * @param string $forSaleMiddleOfTitleInIndex
     */
    public function setForSaleMiddleOfTitleInIndex($forSaleMiddleOfTitleInIndex)
    {
        $this->forSaleMiddleOfTitleInIndex = $forSaleMiddleOfTitleInIndex;
    }

    /**
     * @return string
     */
    public function getForSaleMiddleOfTitleInFilteredIndex()
    {
        return $this->forSaleMiddleOfTitleInFilteredIndex;
    }

    /**
     * @param string $forSaleMiddleOfTitleInFilteredIndex
     */
    public function setForSaleMiddleOfTitleInFilteredIndex($forSaleMiddleOfTitleInFilteredIndex)
    {
        $this->forSaleMiddleOfTitleInFilteredIndex = $forSaleMiddleOfTitleInFilteredIndex;
    }

    /**
     * @return string
     */
    public function getForSaleMiddleOfTitleInShow()
    {
        return $this->forSaleMiddleOfTitleInShow;
    }

    /**
     * @param string $forSaleMiddleOfTitleInShow
     */
    public function setForSaleMiddleOfTitleInShow($forSaleMiddleOfTitleInShow)
    {
        $this->forSaleMiddleOfTitleInShow = $forSaleMiddleOfTitleInShow;
    }

    /**
     * @return string
     */
    public function getMallPreTitle()
    {
        return $this->mallPreTitle;
    }

    /**
     * @param string $mallPreTitle
     */
    public function setMallPreTitle($mallPreTitle)
    {
        $this->mallPreTitle = $mallPreTitle;
    }

    /**
     * @return string
     */
    public function getHomepageMetaTitle()
    {
        return $this->homepageMetaTitle;
    }

    /**
     * @param string $homepageMetaTitle
     */
    public function setHomepageMetaTitle($homepageMetaTitle)
    {
        $this->homepageMetaTitle = $homepageMetaTitle;
    }

    /**
     * @return string
     */
    public function getHomepageMetaDescription()
    {
        return $this->homepageMetaDescription;
    }

    /**
     * @param string $homepageMetaDescription
     */
    public function setHomepageMetaDescription($homepageMetaDescription)
    {
        $this->homepageMetaDescription = $homepageMetaDescription;
    }


}
