<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\Job;
use App\Form\ApplicantType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{

    // /**
    //  * @Route("/jobs", name="job_index")
    //  */
    // public function index(JobRepository $jobRepo)
    // {
    //     return $this->render('jobs/index.html.twig', [
    //         'jobs' => $jobRepo->findBy([], ['createdAt' => 'DESC'])
    //     ]);
    // }

    /**
     * @Route("/jobs/{slug}", name="job_show")
     */
    public function show(Job $job, Request $request, EntityManagerInterface $em)
    {
        $applicant = new Applicant();
        $form = $this->createForm(ApplicantType::class, $applicant);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $applicant->setJob($job);

            $em->persist($applicant);

            $em->flush();

            $this->addFlash('success', 'Your demand were saved!');
        }

        return $this->render('jobs/show.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }
}
