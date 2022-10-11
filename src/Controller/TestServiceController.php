<?php

namespace App\Controller;

use App\Service\MailerWithSenderLogger;
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
}
