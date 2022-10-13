<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Vehicle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class VehicleWithoutModelMailer
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(Vehicle $vehicle): void
    {
        $email = (new Email())
            ->subject("Vehicule {$vehicle->getPlate()} sans modèle")
            ->text("Le véhicule {$vehicle->getPlate()} a été créé sans modèle.")
            ->addTo('admin@monsite.com') // TODO : passer par une variable !
            ->addFrom('no-reply@monsite.com'); // TODO : passer par une variable !

        $this->mailer->send($email);
    }
}
