<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Applicant;
use App\EventSubscriber\MailerSubscriber;
use App\Form\ApplicantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

            $dispatcher = new EventDispatcher();
            $dispatcher->addSubscriber(new MailerSubscriber());

            return $this->redirectToRoute("home_index");
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
