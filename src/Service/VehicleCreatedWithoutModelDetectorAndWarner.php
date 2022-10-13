<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Vehicle;
use App\Entity\VehicleModel;
use Doctrine\ORM\Event\LifecycleEventArgs;

class VehicleCreatedWithoutModelDetectorAndWarner
{
    private VehicleWithoutModelMailer $vehicleWithoutModelMailer;

    public function __construct(VehicleWithoutModelMailer $vehicleWithoutModelMailer)
    {
        $this->vehicleWithoutModelMailer = $vehicleWithoutModelMailer;
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        // La méthode doit porter le nom de l'évènement déclaré dans services.yaml
        // Noter que le paramètre LifecycleEventArgs permet également d'accéder à l'EntityManager

        $entity = $args->getObject();

        if(!$entity instanceof Vehicle) {
            // Ne rien faire s'il ne s'agit pas d'une entité Vehicle => ne pas oublier ce test !
            return;
        }

        if($entity->getVehicleModel() instanceof VehicleModel) {
            // Ne rien faire dans ce cas car le modèle est bien renseigné
            return;
        }

        // Faire appel au service Mailer qui enverra l'alerte
        $this->vehicleWithoutModelMailer->sendEmail($entity);
    }
}
