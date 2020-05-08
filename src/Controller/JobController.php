<?php
namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\Job;
use App\Form\ApplicantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobController extends AbstractController
{
    /**
     * @Route("/jobs/{slug}", name="job_index")
     */
    public function index($slug = null, Request $request, EntityManagerInterface $em)
    {
        $applicant = new Applicant();
        $form = $this->createForm(ApplicantType::class, $applicant);

        $form->handleRequest($request);

        $jobRepo = $em->getRepository(Job::class);
        
        if ($form->isSubmitted()) {
            $applicant->setJob($jobRepo->findOneBy(['slug' => $slug]));

            $em->persist($applicant);

            $em->flush();

            $this->addFlash(
                'success',
                'Your demand were saved!'
            );
        }
        $jobs = $jobRepo->findAll();
        if (!empty($slug)) {
            $jobSelected = $jobRepo->findOneBy(['slug' => $slug]);
        } else {
            $jobSelected = count($jobs) > 0 ? $jobs[0] : null;
        }

        return $this->render('jobs/index.html.twig', [
            'jobs' => $jobs, 
            'jobSelected' => $jobSelected, 
            'form' => $form->createView()
        ]);
    }
}