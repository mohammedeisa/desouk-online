<?php

namespace DesoukOnline\RatingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * News
 *
 * @ORM\Table(name="desouk_online_rating")
 * @ORM\Entity
 */
class Rating
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
     * @ORM\Column(name="vote_id", type="string",nullable=false,length=255)
     */
    private $voteId;

    /**
     * @var string
     *
     * @ORM\Column(name="total_votes", type="integer",nullable=true)
     */
    private $totalVotes;

    /**
     * @var string
     *
     * @ORM\Column(name="total_value", type="integer",nullable=true)
     */
    private $totalValue;

    /**
     * @var string
     *
     * @ORM\Column(name="used_ips", type="text",nullable=true)
     */
    private $usedIps;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
    public function getTotalVotes()
    {
        return $this->totalVotes;
    }

    /**
     * @param string $totalVotes
     */
    public function setTotalVotes($totalVotes)
    {
        $this->totalVotes = $totalVotes;
    }

    /**
     * @return string
     */
    public function getTotalValue()
    {
        return $this->totalValue;
    }

    /**
     * @param string $totalValue
     */
    public function setTotalValue($totalValue)
    {
        $this->totalValue = $totalValue;
    }

    /**
     * @return string
     */
    public function getUsedIps()
    {
        return $this->usedIps;
    }

    /**
     * @param string $usedIps
     */
    public function setUsedIps($usedIps)
    {
        $this->usedIps = $usedIps;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getVoteId()
    {
        return $this->voteId;
    }

    /**
     * @param string $voteId
     */
    public function setVoteId($voteId)
    {
        $this->voteId = $voteId;
    }


}
