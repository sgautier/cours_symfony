<?php

namespace App\Controller;

use App\Entity\Tire;
use App\Entity\Vehicle;
use App\Entity\VehicleEquipment;
use App\Entity\VehicleModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/validator', name: 'validator_')]
class ValidatorController extends AbstractController
{
    #[Route('/tire', name: 'tire')]
    public function testValidateTireAction(ValidatorInterface $validator): Response
    {
        // Le validateur est injecté dans le constructeur
        $tire = new Tire();
        $validator->validate($tire);
        return new Response('<body></body>');
    }

    #[Route('/equipment', name: 'equipment')]
    public function testValidateEquipmentAction(ValidatorInterface $validator): Response
    {
        $equipment = (new VehicleEquipment())
            ->setName('Vitres teintées')
            ->setDescription('Vitres teintées');

        $validator->validate($equipment);
        return new Response('<body></body>');
    }

    #[Route('/vehicle', name: 'vehicle')]
    public function testValidateVehicleAction(ValidatorInterface $validator): Response
    {
        $equipment = new VehicleEquipment();
        $model = new VehicleModel();
        $vehicle = (new Vehicle())
            ->setPlate('FV-619-NZ')
            ->setVehicleModel($model)
            ->addEquipment($equipment);
        $validator->validate($vehicle);
        return new Response('<body></body>');
    }
}
