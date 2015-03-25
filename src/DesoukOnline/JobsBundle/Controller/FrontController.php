<?php

namespace DesoukOnline\JobsBundle\Controller;

use DesoukOnline\HomeBundle\Entity\General;
use DesoukOnline\JobsBundle\Entity\Job;
use DesoukOnline\JobsBundle\Entity\JobsConfig;
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
        $config = $this->getDoctrine()->getRepository(get_class(new General()))->getGeneralConfigurationsAndBundleConfigurations(get_class(new JobsConfig()));

        $repository = $this->getDoctrine()
            ->getRepository('DesoukOnlineJobsBundle:Job');
		$query = $repository->createQueryBuilder('j')
			->orderBy("j.createdAt", 'DESC');
		$query = $query->getQuery();

        $jobsResult = $query->getResult();
        $paginator = $this->get('knp_paginator');
        $jobs = $paginator->paginate(
            $jobsResult,
            $this->container->get('request')->query->get('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return array('jobs' => $jobs,'config'=>$config);
    }

    /**
     * @Route("/job/{slug}", name="job")
     * @Template("DesoukOnlineJobsBundle:Front:job.html.twig")
     */
    public function jobAction()
    {
        $config = $this->getDoctrine()->getRepository(get_class(new General()))->getGeneralConfigurationsAndBundleConfigurations(get_class(new JobsConfig()));

        $job = $this->getDoctrine()->getManager()->getRepository(get_class(new Job()))->findOneBy(array('slug' => $this->get('request')->get('slug')));
        return array('job' => $job,'config'=>$config);
    }

}
