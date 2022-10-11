<?php

declare(strict_types=1);

namespace App\Service;

use DateTimeImmutable;
use Monolog\Formatter\FormatterInterface;
use Monolog\Level;
use Monolog\LogRecord;
use Psr\Log\LoggerInterface;
use Stringable;

// On implémente une interface qui décrit ce qu'est un Logger => cela rend notre Logger interchangeable avec
// n'importe quel autre Logger implémentant le même contrat d'interface
class LoggerDumper implements LoggerInterface
{
    private FormatterInterface $formatter;

    // On injecte un Formatter sous forme d'une interface générique
    // => notre Logger est générique et il peut travailler avec n'importe quel Formatter
    public function __construct(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    // Dans cette méthode, j'écris mon code métier : "Qu'est-ce que je fais d'un log ? => je le logue"
    public function log($level, Stringable|string $message, array $context = []): void
    {
        // On appelle notre Formatter pour lui "demander" de formatter le message
        $log = $this->formatter->format(new LogRecord(
            new DateTimeImmutable(),
            'mon_channel',
            $level,
            $message,
            $context,
        ));

        // On effectue le dump du log !
        dump($log);
    }

    public function emergency(Stringable|string $message, array $context = []): void
    {
        $this->log(
            Level::Emergency,
            $message,
            $context,
        );
    }

    public function alert(Stringable|string $message, array $context = []): void
    {
        $this->log(
            Level::Alert,
            $message,
            $context,
        );
    }

    public function critical(Stringable|string $message, array $context = []): void
    {
        $this->log(
            Level::Critical,
            $message,
            $context,
        );
    }

    public function error(Stringable|string $message, array $context = []): void
    {
        $this->log(
            Level::Error,
            $message,
            $context,
        );
    }

    public function warning(Stringable|string $message, array $context = []): void
    {
        $this->log(
            Level::Warning,
            $message,
            $context,
        );
    }

    public function notice(Stringable|string $message, array $context = []): void
    {
        $this->log(
            Level::Notice,
            $message,
            $context,
        );
    }

    public function info(Stringable|string $message, array $context = []): void
    {
        $this->log(
            Level::Info,
            $message,
            $context,
        );
    }

    public function debug(Stringable|string $message, array $context = []): void
    {
        $this->log(
            Level::Debug,
            $message,
            $context,
        );
    }
}
