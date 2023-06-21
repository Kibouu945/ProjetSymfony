<?php

namespace App\Services;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    private MailerInterface $mailer ;
    public function __construct(MailerInterface $mailer )
    {
        $this->mailer = $mailer ;
    }

    public function send(string $to,string $subject, string $TemplateTwig, array $context ): void
    {
        /*
         *@throws TransportExceptionInterface
         * */


        $email = (new TemplatedEmail())
            ->from('cafe@cafe.fr')
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("mails/$TemplateTwig")
            ->context($context);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $transportException ) {
            throw $transportException ;
        }

    }
}
