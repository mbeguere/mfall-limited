<?php

namespace App\Controller;

use App\Repository\JobRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(JobRepository $jobRepo)
    {
        return $this->render('jobs/index.html.twig', [
            'jobs' => $jobRepo->findBy([], ['createdAt' => 'DESC'])
        ]);
    }
}
