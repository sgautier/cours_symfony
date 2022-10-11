<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\RawMessage;

// On implémente une interface qui décrit ce qu'est un Mailer => cela rend notre Mailer interchangeable avec
// n'importe quel autre Mailer implémentant le même contrat d'interface
class MailerWithSenderLogger implements MailerInterface
{
    private MailerInterface $mailer;
    private LoggerInterface $logger;
    private string $logMessage;

    // Notre service a besoin d'un Logger et d'un Mailer car il doit quand même effectuer un envoi d'email !
    public function __construct(MailerInterface $mailer, LoggerInterface $logger, string $logMessage)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->logMessage = $logMessage;
    }

    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        // On déclenche l'envoi effectif de l'email
        $this->mailer->send($message, $envelope);

        // On logue qui a effectué l'envoi de l'email
        $this->logger->info(
            $this->logMessage . implode(
                ', ',
                array_map(
                    fn(Address $from): string => $from->toString(),
                    $message->getFrom(),
                )
            )
        );
    }
}
