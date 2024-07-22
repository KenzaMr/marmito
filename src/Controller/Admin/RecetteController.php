<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('admin/recette', name: 'admin_recette_')]
class RecetteController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(RecetteRepository $repository): Response
    {
        $ingredient = $repository->findAll();
        return $this->render('admin/recette/index.html.twig', [
            'ingredients' => $ingredient
        ]);
    }
    #[Route('/show/{id}', name: 'show', requirements: ['id' => Requirement::DIGITS])]
    public function show(RecetteRepository $repository, $id): Response
    {
        $ingredient = $repository->find($id);
        return $this->render('admin/recette/show.html.twig', [
            'ingredient' => $ingredient
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $obj = new Recette();
        $recette = $this->createForm(RecetteType::class, $obj);
        $recette->handleRequest($request);

        if ($recette->isSubmitted() && $recette->isValid()) {

            $em->persist($recette);
            $em->flush();
            $this->addFlash('sucess',"L'ingredient a été ajouter");

            return $this->redirectToRoute('admin_recette_list');
        }
        return $this->render('admin/recette/new.html.twig', [
            'formulaire_recette' => $recette
        ]);
    }
    #[Route('/edit/{id}', name: 'edit')]
    public function edit(): Response
    {
        return $this->render('admin/recette/edit.html.twig');
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(): response
    {
        return $this->render('admin/recette/delete.html.twig');
    }
}
