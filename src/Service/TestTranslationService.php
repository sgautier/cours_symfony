<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\Translation\TranslatorInterface;

readonly class TestTranslationService
{
    public function __construct(
        private TranslatorInterface $translator
    )
    {
    }

    public function getMessage(): string
    {
        return $this->translator->trans('One term to translate');
    }
}
