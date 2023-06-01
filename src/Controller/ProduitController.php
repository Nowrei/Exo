<?php

namespace App\Controller;

use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
 
        $form=$this->createForm(ProduitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dataForm = $form->getData();
            $dataForm->setUser($user);

            $entityManager->persist($dataForm);
            $entityManager->flush();
            


            return $this->redirectToRoute('app_produit');
        }
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'form' => $form
        ]);
        
    }
}
