<?php

namespace DesoukOnline\RatingBundle\Controller;

use DesoukOnline\RatingBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class RatingController extends Controller
{
    /**
     * @Route("/test_rating")
     * @Template()
     */
    public function indexAction()
    {
        $id = $this->container->get('request')->get('id');
        $id = 'rating_1';
        $ratingObject = $this->getDoctrine()->getManager()->getRepository(get_class(new Rating()))->findOneBy(array('voteId' => $id));
        $totalVotes = 0;
        $rating = 0;
        if ($ratingObject) {
            $totalVotes = $ratingObject->getTotalVotes();
            $totalValue = $ratingObject->getTotalValue();
            $rating = ($rating != 0) ? $totalValue / $totalVotes : 0;
        }
        return array('rating' => $rating, 'total_votes' => $totalVotes, 'id' => $id);
    }

    /**
     * @Route("/desouk_online_vote", name ="desouk_online_vote", options={"expose"=true})
     */
    public function voteAction()
    {
        $units = 5;
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $id = $request->get('id');
        $vote_sent = preg_replace("/[^0-9]/", "", $request->get('stars'));
        $ip = $_SERVER['REMOTE_ADDR'];

        $rating = $em->getRepository(get_class(new Rating()))->findOneBy(array('voteId' => $id));
        if (!$rating) {
            $rating = new Rating();
            $rating->setVoteId($id);
            $rating->setDate(new \DateTime("now"));
            $em->persist($rating);
            $em->flush();
        }
        if ($vote_sent > $units) die("Sorry, vote appears to be invalid."); // kill the script because normal users will never see this.

//connecting to the database to get some information
        $checkIP = unserialize($rating->getusedIps());
        $count = $rating->getTotalVotes(); //how many votes total
        $current_rating = $rating->getTotalValue(); //total number of rating added together and stored
        $sum = $vote_sent + $current_rating; // add together the current vote value and the total vote value
        $tense = ($count == 1) ? "vote" : "votes"; //plural form votes/vote

// checking to see if the first vote has been tallied
// or increment the current number of votes
        ($sum == 0 ? $added = 0 : $added = $count + 1);

// if it is an array i.e. already has entries the push in another value
        ((is_array($checkIP)) ? array_push($checkIP, $ip) : $checkIP = array($ip));
        $insertedIp = serialize($checkIP);

//IP check when voting
        $query = "SELECT p FROM DesoukOnlineRatingBundle:Rating p where p.usedIps like '%" . $ip . "%' and p.voteId =:id";
        $query = $em->createQuery($query)->setParameter('id', $id);
        $voted = $query->getResult();

        if (!$voted) {     //if the user hasn't yet voted, then vote normally...
            if (($vote_sent >= 1 && $vote_sent <= $units)) { // keep votes within range, make sure IP matches
                $qb = $em->createQueryBuilder();
                $update = $qb->update(get_class(new Rating()), 'u')
                    ->set('u.totalVotes', $added)
                    ->set('u.totalValue', $sum)
                    ->set('u.usedIps', "'" . $insertedIp . "'")
                    ->where('u.voteId = :id')
                    ->setParameter('id', $id)
                    ->getQuery()->execute();
                if ($update) setcookie("rating_" . $id, 1, time() + 2592000);
                $count++;
            }
        } //end for the "if(!$voted)"
        $tense = ($added == 1) ? "vote" : "votes"; //plural form votes/vote

// $new_back is what gets 'drawn' on your page after a successful 'AJAX/Javascript' vote
        if ($voted) {
            $sum = $current_rating;
            $added = $count;
        }
        $new_back = array();
        for ($i = 0; $i < 5; $i++) {
            $j = $i + 1;
            if ($i < @number_format($current_rating / $count, 1) - 0.5) $class = "ratings_stars glyphicon-star";
            else $class = "glyphicon-star-empty";
            $new_back[] .= '<span class="glyphicon ratings_stars permanent-star star_' . $j . ' ' . $class . '"></span>';
        }

        $new_back[] .= '<div class="total_votes"><p class="voted"> ';
        if (!$voted) $new_back[] .= '<span class="thanks">شكرا لاهتمامكم</span>';
        else {
            $new_back[] .= '<span class="invalid">لقد تم التصويت مسبقا</span>';
        }
        $new_back[] .= $count . ' صوت' . '</p></div>';
        $allnewback = join("\n", $new_back);

// ========================
        $output = $allnewback;

        return new Response($output);
    }

}
