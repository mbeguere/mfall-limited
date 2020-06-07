<?php

namespace App\Service;

use App\Entity\Applicant;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

class MailerService
{
    private $kernelInterface;

    private $mailer;

    private $twig;

    public function __construct(\Swift_Mailer $mailer, KernelInterface $kernelInterface, Environment $twig)
    {
        $this->kernelInterface  = $kernelInterface;
        $this->mailer           = $mailer;
        $this->twig             = $twig;
    }

    public function send(Applicant $applicant)
    {
        $message = (new \Swift_Message('MFall LIMITED'))
            ->setFrom('fayda44@yahoo.com')
            ->setTo('fayda44@yahoo.com')
            ->setCc(['fayda44@yahoo.com', 'tomlemage@gmail.com'])
            ->setBody(
                $this->twig->render(
                    'emails/apply.html.twig',
                    ['name' => $applicant->getFullname()]
                ),
                'text/html'
            )
            ->attach(
                \Swift_Attachment::fromPath(
                    $this->kernelInterface->getProjectDir() . '/public/uploads/images/resume/' . $applicant->getResume()
                )
            );

        $this->mailer->send($message);
    }
}
