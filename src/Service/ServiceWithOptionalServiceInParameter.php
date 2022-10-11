<?php

declare(strict_types=1);

namespace App\Service;

use Monolog\Formatter\FormatterInterface;

class ServiceWithOptionalServiceInParameter
{
    // Il faut dans ce cas mettre à null la valeur par défaut du paramètre
    // ... et bien entendu gérer le cas où le service est null dans la classe
    private ?FormatterInterface $formatter;

    public function __construct(FormatterInterface $formatter = null)
    {
        $this->formatter = $formatter;

        // Le code ci-dessous est très sale, mais c'est pour illustrer l'exemple
        if (is_null($formatter)) {
            $this->formatter = new JsonFormatter();
        }
    }

    public function getFormatterClassname(): string
    {
        return get_class($this->formatter);
    }
}
