<?php

namespace App\Controller\Admin;

use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Recipe;
use DateTimeImmutable;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/recipe', name: 'admin_recipe_')]

#[IsGranted('ROLE_USER')]
// #[IsGranted('IS_AUTHENTIFICATED')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(RecipeRepository $repository): Response
    {
        $recipes = $repository->findAll();
        return $this->render('admin/recipe/index.html.twig', [
            'formulaire_description' => $recipes
        ]);
    }
    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        $object = new Recipe;
        $form = $this->createForm(RecipeType::class, $object);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $object->setDateOfcreation(new DateTimeImmutable());

            $file = $form->get('thumnailfile')->getData();

            if ($file) {
                $filedir = $this->getParameter('kernel.project_dir') . '/public/img/FileName';
                $fileName = $object->getSlug() . '.' . $file->getClientOriginalExtension();
                $file->move($filedir, $fileName);

                $object->setFileName($fileName);
            }
            $em->persist($object);
            $em->flush();

            $this->addFlash('sucess', 'Une nouvelle catégorie à été créer');
            return $this->redirectToRoute('admin_recipe_index');
        }
        return $this->render('admin/recipe/create.html.twig', [
            'formulaire_creation' => $form
        ]);
    }
    #[Route('/update/{slug}', name: 'update', methods: ['GET', 'POST'])]
    public function update(Recipe $recipe, EntityManagerInterface $em, Request $request): Response
    {
        $recette = $this->createForm(RecipeType::class, $recipe);
        $recette->handleRequest($request);

        if ($recette->isSubmitted() && $recette->isValid()) {
            $em->flush();
            $this->addFlash('sucess', 'Vous avez réussi à modifier la recette');

            $this->redirectToRoute('admin_recipe_index');
        }
        return $this->render('admin/recipe/update.html.twig', [
            'formulaire_modif' => $recette
        ]);
    }
    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Recipe $recipe, EntityManagerInterface $em): Response
    {
        $em->remove($recipe);
        $em->flush();
        $this->addFlash('sucess', 'Vous avez réussi à supprimer la recette');

        return $this->redirectToRoute('admin_recipe_index');
    }
    #[Route('/show/{id}', name: 'show')]
    public function show(Recipe $recipe, RecipeRepository $repository)
    {

        return $this->render('admin/recipe/show.html.twig', [
            'recette'=>$recipe
        ]);
    }
}
