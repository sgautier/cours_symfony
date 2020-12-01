<?php
namespace App\Controller\Twig;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class DefaultController
 * @package App\Controller\Twig
 * @Route("/twig")
 */
class DefaultController extends AbstractController
{
    const TOTO = 10;

    /**
     * @Route("/functions", name="twig_functions")
     * @return Response
     */
    public function functionsAction()
    {
        return $this->render('twig/functions.html.twig');
    }

    /**
     * @Route("/conditions/{stock}", name="twig_conditions")
     * @return Response
     */
    public function conditionsAction($stock)
    {
        return $this->render('twig/conditions.html.twig', ['stock' => $stock]);
    }

    /**
     * @Route("/conditions-for/{nbProducts}", name="twig_conditions_for")
     * @return Response
     */
    public function conditionsForAction($nbProducts)
    {
        $products = [];
        for($i=1 ; $i<=$nbProducts ; $i++) {
            $products[] = [
                'name' => "Produit $i",
                'description' => "Description $i",
                'active' => (boolean)rand(0, 1),
            ];
        }
        return $this->render('twig/conditions-for.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/loop", name="twig_loop")
     * @return Response
     */
    public function loopAction()
    {
        return $this->render('twig/loop.html.twig');
    }

    /**
     * @Route("/operators", name="twig_operators")
     * @return Response
     */
    public function operatorsAction()
    {
        return $this->render('twig/operators.html.twig');
    }

    /**
     * @Route("/tests", name="twig_tests")
     * @return Response
     */
    public function testsAction()
    {
        return $this->render('twig/tests.html.twig');
    }

    /**
     * @Route("/inheritance", name="twig_inheritance")
     * @return Response
     */
    public function inheritanceAction()
    {
        // Dans le contrôleur, on appelle le template fils
        return $this->render('twig/inheritance/child.html.twig');
    }

    /**
     * @Route("/macro", name="twig_macro")
     * @return Response
     */
    public function macroAction()
    {
        return $this->render('twig/macro/usage.html.twig');
    }

    /**
     * @Route("/macro-bis", name="twig_macro_bis")
     * @return Response
     */
    public function macroBisAction()
    {
        return $this->render('twig/macro/declaration_and_usage.html.twig');
    }

    /**
     * @Route("/global-variable", name="twig_global_variable")
     * @return Response
     */
    public function globalVariableAction()
    {
        return $this->render('twig/global_variable.html.twig');
    }

    /**
     * @Route("/urls", name="twig_urls")
     * @return Response
     */
    public function urlsAction()
    {
        $urls = [];
        $urls[] = $this->get('router')->generate('nom-de-ma-route-6', ['year' => 2018, 'month' => '01', 'filename' => 'test']);
        $urls[] = $this->generateUrl('nom-de-ma-route-6', ['year' => 2018, 'month' => '01', 'filename' => 'test']);
        $urls[] = $this->generateUrl('nom-de-ma-route-6', ['year' => 2018, 'month' => '01', 'filename' => 'test'], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->render('twig/urls.html.twig', ['urls' => $urls]);
    }

    /**
     * @Route("/extension", name="twig_extension")
     * @return Response
     */
    public function extensionAction()
    {
        return $this->render('twig/extension.html.twig');
    }
}
