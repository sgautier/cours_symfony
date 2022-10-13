<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Vehicle;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class VehicleVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $subject instanceof Vehicle && in_array($attribute, ['view', 'edit']);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        // Les véhicules avec plaque d'immatriculation peuvent être consultés par tout le monde
        if ('view' === $attribute && $subject->getPlate()) {
            return true;
        }

        // Seul l'utilisateur qui a créé le véhicule peut le modifier (il doit évidemment être connecté !)
        $user = $token->getUser();
        $owner = $subject->getUser();
        dump($subject);
        if ('edit' === $attribute && ($owner instanceof User) && ($user instanceof User) && $user->getId() === $owner->getId()) {
            return true;
        }

        return false;
    }
}
