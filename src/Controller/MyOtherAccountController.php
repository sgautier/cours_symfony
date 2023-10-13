<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my-other-account')]
#[IsGranted('ROLE_USER')]
class MyOtherAccountController extends AbstractController
{
    // Toutes les actions requièrent le rôle ROLE_USER

    #[Route('/', name: 'security_example_home')]
    public function homeAction(): Response
    {
        return new Response("<body>Il faut que l'utilisateur soit ROLE_USER au minimum</body>");
    }
}
