<?php

declare(strict_types=1);

namespace App\Service;

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

// On implémente une interface qui décrit ce qu'est un Formatter => cela rend
// notre Formatter interchangeable avec n'importe quel autre Formatter implémentant
// le même contrat d'interface
class JsonFormatter implements FormatterInterface
{
    public function format(LogRecord $record): mixed
    {
        // On se contente de faire simplement un json_encode
        return json_encode($record);
    }

    public function formatBatch(array $records): mixed
    {
        // On se contente de faire simplement un json_encode
        return json_encode($records);
    }
}
