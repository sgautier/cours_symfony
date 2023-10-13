<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/this-is-my-account')]
class ThisIsMyAccountController extends AbstractController
{
    #[Route('/', name: 'this_is_my_account_home')]
    #[IsGranted('ROLE_USER')]
    public function homeAction(): Response
    {
        return new Response("<body>Cette action nécessite que l'utilisateur soit ROLE_USER</body>");
    }

    #[Route('/informations', name: 'this_is_my_account_informations')]
    public function informationsAction(): Response
    {
        return new Response("<body>Cette action n'est pas protégée</body>");
    }

    #[Route('/test-check-role', name: 'this_is_my_account_test_check_role')]
    public function testCheckRoleAction(Security $security): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            dump("Bienvenue Monsieur l'administrateur");
        } elseif ($security->isGranted("ROLE_USER")) {
            dump("Salut utilisateur");
        } else {
            dump("Qui êtes vous ?");
        }
        return new Response("<body>Cette action n'est pas protégée mais on y fait quand même des tests !</body>");
    }

    #[Route('/test-deny', name: 'this_is_my_account_test_deny')]
    public function testDenyAction(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous ne passerez pas !");
        }
        return new Response("<body>Cette action génère une exception si l'utilisateur n'est pas ROLE_ADMIN</body>");
    }

    #[Route('/test-deny-bis', name: 'this_is_my_account_test_deny_bis')]
    public function testDenyBisAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, "Vous ne passerez pas !");
        return new Response("<body>Cette action génère une exception si l'utilisateur n'est pas ROLE_ADMIN</body>");
    }
}
