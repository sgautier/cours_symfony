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

    #[Route('/force-locale', name: 'force_locale')]
    public function forceLocale(TranslatorInterface $translator): Response
    {
        $labelFr = $translator->trans(
            'header.welcome', // message à traduire
            [], // paramètres pour la traduction => vu plus loin dans le cours
            'messages', // domaine de traduction => vu plus loin dans le cours
            'fr_FR' // locale souhaitée pour la traduction. Symfony fera un fallback de fr_FR vers fr car je n'ai pas de fichier messages.fr_FR.yml
        );
        $labelEn = $translator->trans('header.welcome', [], 'messages', 'en');

        return new Response("<body>Traductions : $labelFr / $labelEn</body>");
    }

    #[Route('/force-locale-in-twig', name: 'force_locale_in_twig')]
    public function forceLocaleInTwig(): Response
    {
        return $this->render('translation/force_locale.html.twig');
    }

    #[Route('/with-variables', name: 'with_variables')]
    public function testWithVariables(TranslatorInterface $translator): Response
    {
        // Par convention, entourer les variables par "%" => %my_var% (ce n'est qu'une convention)
        $label = $translator->trans('My name is %name%', ['%name%' => 'John']);
        return new Response("<body>Traduction : $label</body>");
    }

    #[Route('/with-variables-twig', name: 'with_variables_twig')]
    public function testWithVariablesTwig(): Response
    {
        return $this->render('translation/with_variables.html.twig');
    }

    #[Route('/icu-variable', name: 'icu_variable')]
    public function icuVariable(TranslatorInterface $translator): Response
    {
        $labelFr = $translator->trans('welcome_message', ['name' => 'John']);
        $labelEn = $translator->trans('welcome_message', ['name' => 'John'], 'messages', 'en');
        return new Response("<body>Traduction : $labelFr / $labelEn</body>");
    }
}
