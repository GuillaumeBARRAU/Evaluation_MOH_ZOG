<?php

namespace App\Service;

use App\Entity\Provider;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NotificationService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendProviderNotification(Provider $provider, string $subject, string $message): void
    {
        $email = (new Email())
            ->from('noreply@company.com')
            ->to($provider->getEmail()) // Email du prestataire
            ->subject($subject)
            ->text($message);

        $this->mailer->send($email);
    }
}
