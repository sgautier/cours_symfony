<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RouteTestController extends AbstractController
{
    #[Route('/route/test', name: 'app_route_test')]
    public function index(): Response
    {
        return new Response('<body>Contenu de la réponse</body>');
    }
}
