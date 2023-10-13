<?php

namespace App\Controller\Twig;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

#[Route('/twig')]
class DefaultController extends AbstractController
{
    const TOTO = 10;

    #[Route('/functions', name: 'twig_functions')]
    public function functionsAction(): Response
    {
        return $this->render('twig/functions.html.twig');
    }

    #[Route('/conditions/{stock}', name: 'twig_conditions')]
    public function conditionsAction($stock): Response
    {
        return $this->render('twig/conditions.html.twig', ['stock' => $stock]);
    }

    #[Route('/conditions-for/{nbProducts}', name: 'twig_conditions_for')]
    public function conditionsForAction($nbProducts): Response
    {
        $products = [];
        for ($i = 1; $i <= $nbProducts; $i++) {
            $products[] = [
                'name' => "Produit $i",
                'description' => "Description $i",
                'active' => (boolean)rand(0, 1),
            ];
        }
        return $this->render('twig/conditions-for.html.twig', ['products' => $products]);
    }

    #[Route('/loop', name: 'twig_loop')]
    public function loopAction(): Response
    {
        return $this->render('twig/loop.html.twig');
    }

    #[Route('/operators', name: 'twig_operators')]
    public function operatorsAction(): Response
    {
        return $this->render('twig/operators.html.twig');
    }

    #[Route('/tests', name: 'twig_tests')]
    public function testsAction(): Response
    {
        return $this->render('twig/tests.html.twig');
    }

    #[Route('/inheritance', name: 'twig_inheritance')]
    public function inheritanceAction(): Response
    {
        // Dans le contrôleur, on appelle le template fils
        return $this->render('twig/inheritance/child.html.twig');
    }

    #[Route('/macro', name: 'twig_macro')]
    public function macroAction(): Response
    {
        return $this->render('twig/macro/usage.html.twig');
    }

    #[Route('/macro-bis', name: 'twig_macro_bis')]
    public function macroBisAction(): Response
    {
        return $this->render('twig/macro/declaration_and_usage.html.twig');
    }

    #[Route('/global-variable', name: 'twig_global_variable')]
    public function globalVariableAction(): Response
    {
        return $this->render('twig/global_variable.html.twig');
    }

    #[Route('/urls', name: 'twig_urls')]
    public function urlsAction(RouterInterface $router): Response
    {
        $urls = [];
        $urls[] = $router->generate('nom-de-ma-route-6', ['year' => 2018, 'month' => '01', 'filename' => 'test']);
        $urls[] = $this->generateUrl('nom-de-ma-route-6', ['year' => 2018, 'month' => '01', 'filename' => 'test']);
        $urls[] = $this->generateUrl('nom-de-ma-route-6', ['year' => 2018, 'month' => '01', 'filename' => 'test'], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->render('twig/urls.html.twig', ['urls' => $urls]);
    }

    #[Route('/render', name: 'twig_render')]
    public function renderAction(): Response
    {
        return $this->render('twig/use_render.html.twig');
    }

    #[Route('/extension', name: 'twig_extension')]
    public function extensionAction(): Response
    {
        return $this->render('twig/extension.html.twig');
    }
}
