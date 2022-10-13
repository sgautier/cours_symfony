<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Vehicle;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class VehicleSaveUser implements EventSubscriber
{
    private TokenStorageInterface $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function getSubscribedEvents(): array
    {
        return ['prePersist',];
    }

    public function prePersist(LifecycleEventArgs $args): void
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
