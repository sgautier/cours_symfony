<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Vehicle;
use App\Entity\VehicleModel;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;

// Définir l'évènement qu'on souhaite écouter. La priorité permet d'agencer plusieurs services entre eux
#[AsDoctrineListener(event: Events::postPersist, priority: 0)]
readonly class VehicleCreatedWithoutModelDetectorAndWarner
{
    public function __construct(
        private VehicleMailer $vehicleMailer,
    )
    {
    }

    public function postPersist(PostPersistEventArgs $args): void
    {
        // La méthode doit porter le nom de l'évènement déclaré dans l’annotation de la classe
        // Noter que le paramètre PostPersistEventArgs permet également d'accéder à l'EntityManager (via sa classe parente LifecycleEventArgs)

        $entity = $args->getObject();

        if (!$entity instanceof Vehicle) {
            // Ne rien faire s'il ne s'agit pas d'une entité Vehicle => ne pas oublier ce test !
            return;
        }

        if ($entity->getVehicleModel() instanceof VehicleModel) {
            // Ne rien faire dans ce cas car le modèle est bien renseigné
            return;
        }

        // Faire appel au service Mailer qui enverra l'alerte
        $this->vehicleMailer->vehicleWithoutModelSendEmail($entity);
    }
}
