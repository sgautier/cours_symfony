<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RouteTestController extends AbstractController
{
    #[Route('/route/test', name: 'app_route_test')]
    public function indexAction(): Response
    {
        return new Response('<body>Contenu de la réponse</body>');
    }

    #[Route('/route/with-variable/{id}', name: 'nom-de-ma-route-2')]
    public function routeWithVariableAction($id): Response
    {
        // $id est accessible ici de manière automatique
        return new Response("<body>$id</body>");
    }

    #[Route('/route/with-variable-and-default-value/{page}', name: 'nom-de-ma-route-3', defaults: ['page' => 1])]
    public function withDefaultValuesAction($page): Response
    {
        return new Response("<body>$page</body>");
    }

    #[Route('/route/with-variable-and-default-value-bis/{page}', name: 'nom-de-ma-route-4')]
    public function withDefaultValuesBisAction($page=1): Response
    {
        return new Response("<body>$page</body>");
    }

    #[Route(
        '/route/with-constraint/{page}',
        name: 'nom-de-ma-route-5',
        requirements: ['page' => '\d+'],
        defaults: ['page' => 1]
    )]
    public function withConstraintAction($page): Response
    {
        return new Response("<body>$page</body>");
    }

    #[Route(
        '/route/with-multiple-constraints/{year}/{month}/{filename}.{extension}',
        name: 'nom-de-ma-route-6',
        requirements: [
            'year' => '\d{4}',
            'month' => '\d{2}',
            'extension' => 'html|xml|css|js',
        ],
        defaults: ['extension' => 'html'],
    )]
    public function withMultipleConstraintsAction($year, $month, $filename, $extension): Response
    {
        return new Response("<body>$year, $month, $filename, $extension</body>");
    }

    #[Route(
        '/route/with-http-method-constraint/{page}',
        name: 'nom-de-ma-route-7',
        requirements: ['page' => '\d+'],
        defaults: ['page' => '1'],
        methods: ['GET'],
    )]
    public function withHttpMethodConstraintAction($page): Response
    {
        return new Response("<body>$page</body>");
    }
}
