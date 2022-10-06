<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldTwigController extends AbstractController
{
    #[Route('/twig')]
    public function index(): Response
    {
        return $this->render('hello_world.html.twig');
    }
}
