<?php

namespace App\Controller\Admin;

use App\Entity\Ingredients;
use App\Form\IngredientsType;
use App\Form\RecetteType;
use App\Repository\IngredientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('admin/ingredients', name: 'admin_ingredient_')]
class IngredientsController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(IngredientsRepository $repository): Response
    {
        $ingredient = $repository->findAll();
        return $this->render('admin/ingredient/index.html.twig', [
            'ingredients' => $ingredient
        ]);
    }
    #[Route('/show/{id}', name: 'show', requirements: ['id' => Requirement::DIGITS])]
    public function show(IngredientsRepository $repository, $id): Response
    {
        $ingredient = $repository->find($id);
        return $this->render('admin/ingredient/show.html.twig', [
            'ingredient' => $ingredient
        ]);
    }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $obj = new Ingredients();
        $recette = $this->createForm(IngredientsType::class, $obj);
        $recette->handleRequest($request);

        if ($recette->isSubmitted() && $recette->isValid()) {

            $em->persist($recette);
            $em->flush();
            $this->addFlash('sucess', "L'ingredient a été ajouté");

            return $this->redirectToRoute('admin_ingredient_list');
        }
        return $this->render('admin/ingredient/new.html.twig', [
            'formulaire_recette' => $recette
        ]);
    }
    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Ingredients $recette, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(IngredientsType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('sucess', "L'ingredient a été modifié");

            return $this->redirectToRoute('admin_ingredient_list');
        }
        return $this->render('admin/ingredient/edit.html.twig',[
            'formulaire_recette'=>$form
        ]);
    }
    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Ingredients $recette, EntityManagerInterface $em): response
    {
        $em->remove($recette);
        $em->flush();
        return $this->redirectToRoute('admin_ingredient_index');
    }
}
