<?php

namespace App\Controller;

use App\Service\MailerWithSenderLogger;
use App\Service\ServiceToTestCalls;
use App\Service\ServiceWithOptionalServiceInParameter;
use App\Service\TestScalar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service', name: 'service_')]
class TestServiceController extends AbstractController
{
    #[Route('/send-email', name: 'send_email')]
    public function testSendEmailAction(MailerWithSenderLogger $mailer): Response
    {
        // Note : si à la place du paramètre MailerWithSenderLogger, j'injecte le Mailer de Symfony, cela fonctionne
        // également ! Mais il n'y aura pas de log sous forme de dump de l'expéditeur de l'email au format JSON ;-)
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Ceci est mon objet !')
            ->text('Ceci est un contenu textuel !')
            ->html('<strong>Ceci est un contenu HTML</strong>')
        ;
        $mailer->send($email);
        return new Response('<body></body>');
    }

    #[Route('/test-only-scalar', name: 'test_only_scalar')]
    public function testServiceWithOnlyScalarArgumentsAction(TestScalar $testScalar): Response
    {
        dump((string)$testScalar);
        return new Response('<body></body>');
    }

    #[Route('/test-optional-service-parameter', name: 'test_optional_serv_ce_parameter')]
    public function testServiceWithOptionalServiceInParameterAction(ServiceWithOptionalServiceInParameter $service): Response
    {
        dump($service->getFormatterClassname());
        return new Response('<body></body>');
    }

    #[Route('/test-service-calls', name: 'test_service_calls')]
    public function testServiceCallsAction(ServiceToTestCalls $service): Response
    {
        $service->myMethod();
        return new Response('<body></body>');
    }
}
