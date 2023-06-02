<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowProduitController extends AbstractController
{
    #[Route('produits', name: 'app_show_produit')]
    public function index(): Response
    {
        $user = $this->getUser();

    if ($user->getAge() < 18) {
        return $this->redirectToRoute('app_login');
    }
        return $this->render('show_produit/index.html.twig', [
            'controller_name' => 'ShowProduitController',
        ]);
    }
}
