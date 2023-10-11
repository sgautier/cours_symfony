<?php

namespace App\Controller;

use App\Service\TestTranslationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/translation', name: 'translation_')]
class TranslationTestController extends AbstractController
{
    #[Route('/from-controller', name: 'from_controller')]
    public function fromController(TranslatorInterface $translator): Response
    {
        return new Response("<body>{$translator->trans('One term to translate')}</body>");
    }

    #[Route('/from-service', name: 'from_service')]
    public function fromService(TestTranslationService $service): Response
    {
        return new Response("<body>{$service->getMessage()}</body>");
    }

    #[Route('/from-twig', name: 'from_twig')]
    public function fromTwig(): Response
    {
        return $this->render('translation/example.html.twig');
    }

    #[Route('/get-locale', name: 'get_locale')]
    public function testGetLocale(Request $request): Response
    {
        // Récupération de la locale courante
        $locale = $request->getLocale();
        return new Response("<body>Locale courante : $locale</body>");
    }

    #[Route('/get-locale-bis/{_locale}', name: 'get_locale_bis')]
    public function testGetLocaleBis(Request $request): Response
    {
        // Récupération de la locale transmise en GET
        // Possibilité de restreindre les valeurs possibles (cf. requirements pour la route)
        $locale = $request->getLocale();
        return new Response("<body>Locale courante : $locale</body>");
    }
}
