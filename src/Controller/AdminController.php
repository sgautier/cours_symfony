<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function indexAction(): Response
    {
        dump($this->getUser());
        return new Response("<body>Ceci est l'accueil de l'administration</body>");
    }

    #[Route('/non-protected', name: 'home')]
    public function homeAction(): Response
    {
        dump($this->getUser());
        return new Response("<body>Ceci est une page non protégée de l'administration</body>");
    }

    #[Route('/informations', name: 'informations')]
    public function informationsAction(): Response
    {
        dump($this->getUser());
        return new Response("<body>Ceci est la page où je gère mes informations personnelles</body>");
    }
}
