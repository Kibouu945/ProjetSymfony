<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;

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


    #[Route('/mentions-légales', name: 'mentleg')]
    public function mentionleg(): Response
    {
        return $this->render('home/mentionslegales.html.twig');
    }

    /*
    #[Route('/app_home_set-cookie', name: 'app_home_set-cookie')]
    public function acceptCookies(Request $request): Response {
        // Set a cookie to indicate that cookies have been accepted
        $response = new Response();
        $response->headers->setCookie(new Cookie('cookies_accepted', '1', time() + (365 * 24 * 60 * 60))); // expires in 1 year

        $referer = $request->headers->get('referer');
        return $response->setStatusCode(Response::HTTP_FOUND)->headers->set('Location', $referer);
    }
    */

}
