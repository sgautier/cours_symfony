<?php

namespace App\Controller\Twig;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/twig')]
class DefaultController extends AbstractController
{
    #[Route('/functions', name: 'twig_functions')]
    public function functionsAction(): Response
    {
        return $this->render('twig/functions.html.twig');
    }
}
