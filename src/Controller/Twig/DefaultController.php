<?php

namespace App\Controller\Twig;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        for ($i=1 ; $i<=$nbProducts ; $i++) {
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

}
