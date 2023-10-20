<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsDoctrineListener(event: Events::prePersist, priority: 0)]
readonly class VehicleSaveUser
{
    public function __construct(
        private TokenStorageInterface $token,
    )
    {
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Vehicle) {
            return;
        }

        if (!is_object($token = $this->token->getToken())
            || !is_object($user = $token->getUser())) {
            return;
        }

        $entity->setUser($user);
    }
}
