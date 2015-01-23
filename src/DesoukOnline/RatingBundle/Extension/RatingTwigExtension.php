<?php
/**
 * Created by PhpStorm.
 * User: mohammed
 * Date: 05/12/14
 * Time: 01:21 ص
 */
namespace DesoukOnline\RatingBundle\Extension;

use DesoukOnline\RatingBundle\Entity\Rating;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;


class RatingTwigExtension extends \Twig_Extension
{
    protected $container;
    protected $em;

    public function __construct($em, $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            'show_rating' => new \Twig_Filter_Method($this, 'show_rating'),
        );
    }

    public function show_rating($voteId)
    {
        $rating = $this->em->getRepository('DesoukOnlineRatingBundle:Rating')->findOneBy(array('voteId' => $voteId));
        if (!$rating) {
            $rating = new Rating();
            $rating->setVoteId($voteId);
            $rating->setDate(new \DateTime("now"));
            $this->em->persist($rating);
            $this->em->flush();
        }
        $ratingValue = ($rating->getTotalVotes()) ?  $rating->getTotalValue()/$rating->getTotalVotes()  : 0;
        return $this->container->get('templating')
            ->render("DesoukOnlineRatingBundle:Rating:rating.html.twig", array('rating' => $rating, 'rating_value' => $ratingValue));
    }

    public function getName()
    {
        return 'show_rating';
    }
} 