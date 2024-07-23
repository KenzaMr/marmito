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
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/recipe', name: 'admin_recipe')]
class RecipeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(RecipeRepository $repository): Response
    {
        $form = $repository->findAll();
        return $this->render('admin/recipe/index.html.twig', [
            'formulaire_description' => $form
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

            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($object->getName());
            $object->setSlug(strtolower($slug));

            $em->persist($object);
            $em->flush();

            $this->addFlash('sucess', 'Une nouvelle catégorie à été créer');
            return $this->redirectToRoute('admin_recipe_index');
        }
        return $this->render('admin/recipe/create.html.twig', [
            'formulaire_creation' => $form
        ]);
    }
}
