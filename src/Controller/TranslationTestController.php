<?php

namespace App\Controller;

use App\Service\TestTranslationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
