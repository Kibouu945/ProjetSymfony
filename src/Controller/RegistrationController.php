<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Services\MailerService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use function Symfony\Component\Clock\now;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
     EntityManagerInterface $entityManager, MailerService $mailerService,
     TokenGeneratorInterface $tokenGeneratorInterface ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // create token
            $tokenRegistration = $tokenGeneratorInterface->generateToken();

            //User

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            //User token verification

            $user->setTokenRegistration($tokenRegistration);
            $entityManager->persist($user);
            $entityManager->flush();

            // Send email
            $mailerService->send(
                $user->getEmail(),
                'Activation de votre compte',
                'registration_confirmation.html.twig',
                [
                    'token' => $tokenRegistration,
                    'user' => $user,
                    'lifeTimeToken' => $user->getTokenRegistrationLifetime()->format('d-m-Y H:i:s')

                ]
            );

            $this->addFlash('success', 'Votre compte a bien été créé, verifier votre compte email pour l\'activer !');


            return $this->redirectToRoute('app_login');
        }


        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/{token}/{id<\d+>}', name: 'account_verify',methods: ['GET'])]
    public function verify(string $token,User $user,EntityManagerInterface $em): Response
    {
        if($user->getTokenRegistration()!==$token){
           throw new AccessDeniedException('Le token n\'est pas valide');
        }

        if($user->getTokenRegistration() === null){
            throw new AccessDeniedException('Le token n\'est pas valide');
        }

        if(new DateTime('now') > $user->getTokenRegistrationLifetime()){
            throw new AccessDeniedException('Le token n\'est plus valide');
        }

        $user->setIsVerified(true);
        $user->setTokenRegistration(null);
        $em->flush();

        $this->addFlash('success','Votre compte a bien été activé !');

        return $this->redirectToRoute('app_login');
    }
}
