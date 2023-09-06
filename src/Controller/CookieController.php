<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class CookieController extends AbstractController
{
     /**
     * @Route("/accept-cookies", name="accept_cookies", methods={"POST"})
     */
    
    public function acceptCookies(Request $request): JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true);

            if ($data['accept'] ?? false) {
                $response = new JsonResponse(['accepted' => true]);
                $response->headers->setCookie(new Cookie('cookies_accepted', 'true', time() + (2 * 365 * 24 * 60 * 60)));
                return $response;
            }
        }

        return new JsonResponse(['accepted' => false], 400);
    }
    
}
