<?php

namespace App\Controller;

use App\Entity\Tire;
use App\Form\TireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tire', name: 'tire_')]
class TireController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function addAction(): Response
    {
        $tire = new Tire(); // Initialisation de l'objet sur lequel le formulaire va reposer
        // En donnant des valeurs par défaut à des propriétés de l'objet, les champs correspondant du formulaire
        // auront des valeurs par défaut (ce n'est pas obligatoire)
        $tire->setBrandName('Michelin')->setPrice(79);

        // Initialisation du formulaire à partir de l'objet créé
        $form = $this->createFormBuilder($tire)
            // Puis ajout de chacun des champs du formulaire via la méthode add()
            ->add('brandName', TextType::class)
            ->add('price', MoneyType::class, ['currency' => 'EUR']) // Certains champs peuvent avoir des paramètres
            ->add('send', SubmitType::class, ['label' => 'Add a new tire'])
            ->getForm();

        // Noter que dans cette action, on se contente d'initialiser un formulaire sans gérer sa validation

        return $this->render('tire/form.html.twig', [
            // Création d'une vue pour le formulaire => nous verrons ensuite comment afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/add-bis', name: 'add_bis')]
    public function addBisAction(): Response
    {
        // Aucun changement pour la création de l'objet
        $tire = new Tire();
        $tire->setBrandName('Michelin')->setPrice(79);

        $form = $this->createForm(TireType::class, $tire);
        // Eventuellement, ajout de champs supplémentaires (classiquement les boutons de validation pour ne pas polluer le formulaire)
        // Il est également possible de supprimer des champs si on le souhaite (en fonction d'un besoin métier particulier
        $form->add('send', SubmitType::class, ['label' => 'Add a new tire']);

        // Aucun changement
        return $this->render('tire/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/add-full', name: 'add_full')]
    public function addTireAction(Request $request): Response
    {
        $tire = new Tire();
        $form = $this->createForm(TireType::class, $tire);
        $form->add('send', SubmitType::class, ['label' => 'Add a new tire']);
        $form->handleRequest($request); // Alimentation du formulaire avec la Request

        if ($form->isSubmitted() && $form->isValid()) {
            // Le formulaire vient d'être soumis et il est valide => $tire est hydraté avec les données saisies

            // Traitement des données du formulaire...

            return $this->redirectToRoute('tire_add_success');
        }

        // Affichage du formulaire initial (requête GET) OU affichage du formulaire avec erreurs après validation (requête POST)
        return $this->render('tire/form.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/add/success', name: 'add_success')]
    public function addTireSuccessAction(): Response
    {
        return $this->render('tire/success.html.twig');
    }
}
