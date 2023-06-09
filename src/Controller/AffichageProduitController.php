<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\Produit1Type;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affichage')]
class AffichageProduitController extends AbstractController
{
    // #[Route('/posts/{id}', name: 'post_show')]
    // public function show($id): Response
    // {
    //     get a Post object - e.g. query for it
    //     $produit = $produit->getUser() !== $this->getUser();

    //     check for "view" access: calls all voters
    //     $this->denyAccessUnlessGranted('view', $produit);

    //     ...
    // }

    // #[Route('/posts/{id}/edit', name: 'post_edit')]
    // public function edit($id): Response
    // {
    //     get a Post object - e.g. query for it
    //     $produit = $produit->getUser() !== $this->getUser();

    //     check for "edit" access: calls all voters
    //     $this->denyAccessUnlessGranted('edit', $produit);

    //     ...
    // }

    #[Route('/', name: 'app_affichage_produit_index', methods: ['GET'])]
    
    public function index(ProduitRepository $produitRepository): Response
    {
        
        return $this->render('affichage_produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_affichage_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        $produit = new Produit();
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_affichage_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affichage_produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affichage_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        if ($produit->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        return $this->render('affichage_produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affichage_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_affichage_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('affichage_produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_affichage_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_affichage_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
