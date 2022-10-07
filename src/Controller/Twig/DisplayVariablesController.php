<?php

namespace App\Controller\Twig;

use App\MySampleClass\MyClass1;
use App\MySampleClass\MyClass2;
use App\MySampleClass\MyClass3;
use App\MySampleClass\MyClass4;
use App\MySampleClass\MyClass5;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/twig')]
class DisplayVariablesController extends AbstractController
{
    #[Route('/display_variables', name: 'twig_display_variables')]
    public function displayVariablesAction(): Response
    {
        return $this->render('twig/display_variables.html.twig', [
            'my_variable' => 'My value',
            'my_variable_array' => ['name' => 'This is the value for the key "name"'],
            'my_variable1' => new MyClass1(),
            'my_variable2' => new MyClass2(),
            'my_variable3' => new MyClass3(),
            'my_variable4' => new MyClass4(),
            'my_variable5' => new MyClass5(),
        ]);
    }
}
