<?php

namespace App\Services;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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
            ->from('gustocoffee@f2i-dev22-rt-gm-mg-ag.fr')
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
    /*
    // Envoyer un mail de bienvenue à l'inscription
    public function sendWelcomeEmail(User $user): void
    {
        $this->send(
            $user->getEmail(),
            'Bienvenue sur notre site !',
            'welcome.html.twig',
            ['user' => $user]
        );
    }



    // Envoyer un mail de confirmation de réservation
    public function sendReservationConfirmation(Reservation $reservation): void
    {
        $this->send(
            $reservation->getUser()->getEmail(),
            'Confirmation de votre réservation',
            'reservation_confirmation.html.twig',
            ['reservation' => $reservation]
        );
    }

     * */
}
