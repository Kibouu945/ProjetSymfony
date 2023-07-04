<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/services', name: 'service')]
    public function services(): Response
    {
        return $this->render('home/services.html.twig');
    }

    #[Route('/a-propos', name: 'about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }
    
    #[Route('/reservation', name: 'reservation')]
    public function reservation(): Response
    {

         /*
      
        // Vérifier si l'utilisateur est connecté
        if ($this->getUser()) {
            // L'utilisateur est déjà connecté, vous pouvez traiter la réservation ici

            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $dateReservation = $request->request->get('date_reservation');
            $typeSalon = $request->request->get('type_salon');
            $dureeReservation = $request->request->get('duree_reservation');
            $typeForfait = $request->request->get('type_forfait');

            // Redirection vers la page de confirmation de réservation
            return $this->redirectToRoute('reservation_confirmation');
        }

        // L'utilisateur n'est pas connecté, redirection vers la page de connexion
        return $this->redirectToRoute('app_login');

        
      */ 
        
        return $this->render('home/reservation.html.twig');
    }
    

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig');
    }


}
