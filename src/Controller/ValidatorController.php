<?php

namespace App\Controller;

use App\Entity\Tire;
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
        dump($validator->validate($tire));
        return new Response('<body></body>');
    }
}
