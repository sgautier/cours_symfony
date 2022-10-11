<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/')]
    public function indexAction(): Response
    {
        return new Response('<body>Hello World !</body>');
    }

    #[Route('/hello', name: 'hello')]
    public function helloWorldBisAction(Request $request): Response
    {
        dump($request->query->get('toto'));
        return new Response('Hello World !');
    }
}
