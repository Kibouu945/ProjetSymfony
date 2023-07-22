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
        return $this->render('home/reservation.html.twig');
    }
    

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig');
    }


}
