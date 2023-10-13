<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TruncateExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('truncate', [$this, 'truncate']),
        ];
    }

    public function truncate($text, $max = 30): string
    {
        if (mb_strlen($text) > $max) {
            $text = mb_substr($text, 0, $max);
            $text = mb_substr($text, 0, mb_strrpos($text, ' '));
            $text .= '...';
        }
        return $text;
    }
}
