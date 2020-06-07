<?php

namespace App\EventSubscriber;

use App\Repository\ApplicantRepository;
use App\Service\MailerService;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class MailerSubscriber implements EventSubscriberInterface
{
    private $applicantRepository;

    private $mailerService;

    public function __construct(ApplicantRepository $applicantRepository, MailerService $mailerService)
    {
        $this->applicantRepository  = $applicantRepository;
        $this->mailerService        = $mailerService;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponsePost',
        ];
    }

    public function onKernelResponsePost(ResponseEvent $event)
    {
        if ($event->getRequest()->getMethod() === 'POST' && $event->getRequest()->request->get('applicant')) {
            $email = $event->getRequest()->request->get('applicant')['email'];
            $applicant = $this->applicantRepository->findOneBy(['email' => $email]);
            // Send
            $this->mailerService->send($applicant);
        }
    }
}
