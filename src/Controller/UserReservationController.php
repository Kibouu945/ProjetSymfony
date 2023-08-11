<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;

class UserReservationController extends AbstractController
{
    #[Route('/user/reservation', name: 'app_user_reservation')]
    public function listReservations(): Response
    {
       
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        if (!$user) {
            // Rediriger vers la page de connexion ou afficher un message d'erreur
            return $this->redirectToRoute('app_login'); 
        }

        // Récupère les réservations de l'utilisateur à partir de la base de données
        $reservations = $this->getDoctrine()
            ->getRepository(Reservation::class)
            ->findBy(['user' => $user]);

        // Rendre la vue avec les réservations
        return $this->render('reservation/user_reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    

    }
}
