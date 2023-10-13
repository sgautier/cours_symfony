<?php

declare(strict_types=1);

namespace App\Controller\Twig;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/twig')]
class FiltersController extends AbstractController
{
    #[Route('/filters', name: 'twig_filters')]
    public function filtersAction(): Response
    {
        return $this->render('twig/filters.html.twig', [
            'createdAt' => new DateTime('now'),
            'name' => 'This is my name',
            'tags' => [56, 'z', 'B', 'H', 6, 92, 9, 'Test', 32],
        ]);
    }
}
