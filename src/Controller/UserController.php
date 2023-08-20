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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


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


    #[Route('/utilisateur/suppression-profil/{id}', name: 'user.delete', methods: ['GET', 'POST'])]
    public function delete(EntityManagerInterface $entityManager , User $user): Response
    {
        // Vérification si l'utilisateur est connecté
        $currentUser = $this->getUser();
        if (!$currentUser) {
            throw new AccessDeniedException('Vous devez être connecté pour accéder à cette section.');
        }

        // Vérification si l'utilisateur a le droit de supprimer ce profil (c'est son profil ou il est admin)
        if ($currentUser->getId() !== $user->getId() && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas le droit de supprimer ce profil.');
        }

        // Si tout va bien, supprimez le profil
        $entityManager->remove($user);
        $entityManager->flush();

        // Ajouter un flash message pour notifier l'utilisateur
        $this->addFlash('success', 'Profil supprimé avec succès.');

        // Rediriger vers la page d'accueil ou de connexion après la suppression
        return $this->redirectToRoute('app_login');
    }
}

