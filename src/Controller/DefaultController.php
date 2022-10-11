<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class DefaultController extends AbstractController
{
    #[Route('/my-404', name: 'my_404')]
    public function my404Action(): Response
    {
        $response = new Response(); // Initialisation de la réponse
        $response->setStatusCode(Response::HTTP_NOT_FOUND); // Code de la réponse
        $response->setContent('Ma page 404'); // Contenu de la réponse
        return $response; // Retour de la réponse
    }

    #[Route('/display-results/{page}', name: 'display_results', requirements: ['page' => '\d+'], defaults: ['page' => 1])]
    public function displayResultsAction($page): Response
    {
        // La page DOIT être un entier strictement positif (les requirements s'assurent uniquement du fait que la
        // variable est composée de chiffres)
        if($page < 1) {
            throw new NotFoundHttpException("La page $page n'existe pas");
        }

        return new Response("<body>Affichage de la page $page</body>");
    }


    #[Route('/test-redirect')]
    public function testRedirectAction(RouterInterface $router): RedirectResponse
    {
        return new RedirectResponse($router->generate('hello'));
    }

    #[Route('/test-redirect-bis')]
    public function testRedirectBisAction(RouterInterface $router): RedirectResponse
    {
        return $this->redirect($router->generate('hello'));
    }

    #[Route('/test-redirect-ter')]
    public function testRedirectTerAction(): RedirectResponse
    {
        return $this->redirectToRoute('hello');
    }

    #[Route('/test-redirect-with-param')]
    public function testRedirectWithParamAction(): RedirectResponse
    {
        return $this->redirectToRoute('display_results', [
            'page' => 123,
        ]);
    }

    #[Route('/test-response-json')]
    public function sendJsonAction(): JsonResponse
    {
        // Ne pas oublier dans ce cas le use nécessaire : Symfony\Component\HttpFoundation\JsonResponse;
        return new JsonResponse(['toto' => 'titi']);
    }

    #[Route('/test-response-json-bis')]
    public function sendJsonBisAction(): Response
    {
        // Initialisation de la réponse avec le contenu attendu : du JSON
        $response = new Response(json_encode(['toto' => 'titi']));

        // Définition du Content-Type
        $response->headers->set('Content-Type', 'application/json');

        // Retour de la réponse
        return $response;
    }

    #[Route('/test-session')]
    public function testSessionAction(Request $request): Response
    {
        // Récupération de la session
        $session = $request->getSession();

        // Accès à une variable de la session
        // Uniquement à la première exécution, variable
        // vide (cf. instruction suivante)
        dump($session->get('toto'));

        // Définition d'une variable en session
        // Une fois l'action exécutée au moins une fois,
        // cette ligne peut être retirée et le dump()
        // ci-dessus continuera à afficher la valeur
        // 1234 (tant que la session ne sera pas détruite)
        $session->set('toto', 1234);

        return new Response('<body></body>');
    }

    #[Route('/test-session-bis')]
    public function testSessionBisAction(Session $session): Response
    {
        // Autre manière de récupérer la session : paramètre du contrôleur
        dump($session->get('toto'));
        $session->set('toto', 1234);
        return new Response('<body></body>');
    }

    #[Route('/test-flash')]
    public function testFlashCrudAction(Session $session): Response
    {
        // ... faire un traitement particulier

        // valeur 'info' libre : c'est le développeur qui choisit ses étiquettes
        $session->getFlashBag()->add('info', "Tout s'est bien passé :-)");

        // Méthode équivalente :
        $this->addFlash('info', "Tout s'est vraiment bien passé :-)");

        return $this->redirectToRoute('test_flash_result');
    }

    #[Route('/test-flash-result', name: 'test_flash_result')]
    public function testFlashResultAction(): Response
    {
        return $this->render('test_flash_bag.html.twig');
    }
}
