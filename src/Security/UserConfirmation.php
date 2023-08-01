<?php

namespace App\Security;


use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserConfirmation implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }


    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isIsVerified()) {
            throw new CustomUserMessageAccountStatusException('Votre compte n\'est encore pas vérifié, Merci de le confirmer avant le ' . $user->getTokenRegistrationLifetime()->format('d/m/Y à H:i:s') . ' en cliquant sur le lien dans l\'email de confirmation que vous avez reçu.');
        }
    }
}