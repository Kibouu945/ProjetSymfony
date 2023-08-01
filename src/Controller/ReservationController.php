<?php

namespace App\Controller;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation-process', name: 'process_reservation')]
    
    public function processReservation(Request $request, EntityManagerInterface $entityManager): Response {


        $user = $this->getUser();
        
        // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $bookingDate = new \DateTime($request->request->get('booking_date'));

        $typeSalle = $request->request->get('type_salle');

        if (null === $typeSalle || '' === $typeSalle) {
            $this->addFlash('error', 'Vous devez choisir un type de salle.');
            return $this->redirectToRoute('reservation');
        }

        $forfait = $request->request->get('forfait');

        // Si l'utilisateur n'a pas choisi de package, utilisez une valeur par défaut
        if (null === $forfait || '' === $forfait) {
            $forfait = 'none'; // ou une autre valeur par défaut de votre choix
        }
        
        $forfait = $request->request->get('nom');
     
        $nombreSalle = (int)$request->request->get('nombre_salle');
        
        // Vérification du nombre de places réservées si le type de salle est "place"

        if ($typeSalle === 'place') {
            // Vérifier si le nombre total de places réservées dépasse 120
            $totalPlacesReservees = $this->getTotalPlacesReservees($entityManager, 'place');
            if ($totalPlacesReservees + $nombreSalle > 120) {
                return new Response('Plus de place disponible');
            }
        } elseif ($typeSalle === 'salon') {
            // Vérifier si le nombre total de place reservé pour le salon privé est compris entre 4 et 6
            $totalSalonsReserves = $this->getTotalSalonsReserves($entityManager);
            if ($nombreSalle < 4 || $nombreSalle > 6) {
                return new Response('Le nombre de place de ce type de salon doit être compris entre 4 et 6');
            }
        } 

        // Créer une nouvelle réservation
        
        $reservation = new Reservation();
        $reservation ->setUser($user)
            ->setBookingDate($bookingDate)
            ->setTypeSalle($typeSalle)
            ->setNombreSalle($nombreSalle) 
            ->setForfait($forfait);

            // Enregistrer la réservation dans la base de données
            $entityManager->persist($reservation);
            $entityManager->flush();

            return new Response('Réservation effectuée avec succès !');

    }


    private function getTotalPlacesReservees(EntityManagerInterface $entityManager, string $typeSalle): int
    {
        $repository = $entityManager->getRepository(Reservation::class);
        $reservations = $repository->findBy(['type_salle' => $typeSalle]);

        $totalPlaces = 0;
        foreach ($reservations as $reservation) {
            $totalPlaces += $reservation->getNombreSalle();
        }

        return $totalPlaces;
    }

    private function getTotalSalonsReserves(EntityManagerInterface $entityManager): int
    {
        $repository = $entityManager->getRepository(Reservation::class);
        $reservations = $repository->findBy(['type_salle' => 'salon']);

        return count($reservations);
    }
}


