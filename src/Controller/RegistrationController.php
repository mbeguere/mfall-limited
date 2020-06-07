<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\Job;
use App\Form\ApplicantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration_index")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $applicant = new Applicant();
        $form = $this->createForm(ApplicantType::class, $applicant);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($applicant);
            $em->flush();

            $this->addFlash('success', 'Your demand were saved!');

            return $this->redirectToRoute("home_index");
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
