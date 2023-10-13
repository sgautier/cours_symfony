<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/profile', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function indexAction(): Response
    {
        return new Response('<body>Ai-je les droits ?</body>');
    }

    #[Route('/home', name: 'home')]
    public function homeAction(): Response
    {
        return new Response("<body>Ceci est l'accueil de mon compte</body>");
    }

    #[Route('/informations', name: 'informations')]
    public function informationsAction(): Response
    {
        return new Response("<body>Ceci est la page où je gère mes informations personnelles</body>");
    }

    #[Route('/test-get-user', name: 'test_get_user')]
    public function testGetUserAction(Security $security): Response
    {
        dump($this->getUser());
        dump($security->getUser());
        return $this->render('security/get_user.html.twig');
    }
}
