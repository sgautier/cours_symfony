<?php
namespace App\Controller\Twig;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller\Twig
 * @Route("/twig")
 */
class RenderExampleController extends AbstractController
{
    /**
     * @param $nbProducts
     * @return Response
     */
    public function bestSalesAction($nbProducts)
    {
        // Evidemment, dans la vraie vie, les produits sont chargés depuis la base de données par exemple
        $products = [];
        for($i=1 ; $i<=$nbProducts ; $i++) {
            $products[] = ['name' => 'Product ' . $i, 'price' => 25+$i,];
        }
        return $this->render('twig/best_sales.html.twig', ['products' => $products]);
    }
}
