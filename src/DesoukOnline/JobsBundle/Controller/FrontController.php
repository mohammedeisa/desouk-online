<?php

namespace DesoukOnline\JobsBundle\Controller;

use DesoukOnline\JobsBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FrontController extends Controller
{
    /**
     * @Route("/jobs", name="jobs")
     * @Template("DesoukOnlineJobsBundle:Front:index.html.twig")
     */
    public function indexAction()
    {
        $jobsResult = $this->getDoctrine()->getManager()->getRepository(get_class(new Job()))->findAll();
        $paginator = $this->get('knp_paginator');
        $jobs = $paginator->paginate(
            $jobsResult,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return array('jobs' => $jobs);
    }

    /**
     * @Route("/job/{slug}", name="job")
     * @Template("DesoukOnlineJobsBundle:Front:job.html.twig")
     */
    public function jobAction()
    {
        $job = $this->getDoctrine()->getManager()->getRepository(get_class(new Job()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('job' => $job);
    }

}
