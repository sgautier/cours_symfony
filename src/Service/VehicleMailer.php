<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Vehicle;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class VehicleMailer
{
    public function __construct(
        private MailerInterface $mailer
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function vehicleWithoutModelSendEmail(Vehicle $vehicle): void
    {
        $email = (new Email())
            ->subject("Vehicule {$vehicle->getPlate()} sans modèle")
            ->text("Le véhicule {$vehicle->getPlate()} a été créé sans modèle.")
            ->addTo('admin@monsite.com') // TODO : passer par une variable !
            ->addFrom('no-reply@monsite.com'); // TODO : passer par une variable !

        $this->mailer->send($email);
    }

    public function vehicleNeedsRepairsSendEmail(Vehicle $vehicle): void
    {
        // ...
    }
    // Autres méthodes pour des envois d'emails liés à un Vehicle
}
