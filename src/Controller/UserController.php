<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User; 
use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; 


class UserController extends AbstractController
{
    #[Route('/page-utilisateur', name: 'user_homepage')]
    public function index()
    {

        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }



    // #[Route('/utilisateur/edition-mot-de-passe/{id}', 'user.edit.password', methods: ['GET', 'POST'])]
    // public function editPassword(
    //     User $choosenUser,
    //     Request $request,
    //     EntityManagerInterface $manager,
    //     UserPasswordHasherInterface $hasher
    // ): Response {
    //     $form = $this->createForm(ChangePasswordFormType::class );

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         if ($hasher->isPasswordValid($choosenUser, $form->getData()['plainPassword'])) { 
    //             $choosenUser->
    //                 $form->getData()['newPassword']
    //             ;

    //             $this->addFlash(
    //                 'success',
    //                 'Le mot de passe a été modifié.'
    //             );

    //             $manager->persist($choosenUser);
    //             $manager->flush();

    //             return $this->redirectToRoute('user_homepage');
    //         } else {
    //             $this->addFlash(
    //                 'warning',
    //                 'Le mot de passe renseigné est incorrect.'
    //             );
    //         }
    //     }

    //     return $this->render('user/update.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }


    #[Route('/utilisateur/edition-mot-de-passe/{id}', name: 'user.edit.password', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_USER")] 
    public function editPassword(
        User $choosenUser,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher
    ): Response {
        $form = $this->createForm(ChangePasswordFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $choosenUser; // Use the injected $choosenUser directly
            

            $plainPassword = $form->get('newPassword')->getData();
 

            if (null !== $plainPassword) {
                $hashedPassword = $hasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

         

            $manager->flush();

            $this->addFlash(
                'success',
                'Le mot de passe a été modifié.'
            );

            return $this->redirectToRoute('app_logout');
             
        }

        return $this->render('user/update.html.twig', [
            'form' => $form->createView()
        ]);
    }




}
