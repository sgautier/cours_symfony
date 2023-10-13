<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/route-bis', name: 'prefixe_pour_name_')]
class RouteTestBisController extends AbstractController
{
    // En réalité, la route de cette action sera /route-bis/test
    #[Route('/test', name: 'nom-de-ma-route-bis')]
    public function testAction(): Response
    {
        return new Response('<body>Contenu de la réponse</body>');
    }

    // En réalité, la route de cette action sera /route-bis/with-variable/{id}
    #[Route('/with-variable/{id}', name: 'nom-de-ma-route-2-bis')]
    public function routeWithVariableAction($id): Response
    {
        // $id est accessible ici de manière automatique
        return new Response("<body>$id</body>");
    }

    // ...
}
