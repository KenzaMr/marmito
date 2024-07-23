<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\AsciiSlugger;

class RecipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $slugger = new AsciiSlugger();


        $faker=\Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));
        $recette=new Recipe;
        $recette->setName($faker->foodName());
        $recette->setSlug('');
        $recette->setTime(4);
        $recette->setNbPersonne(4);
        $recette->setDifficulties(3);
        $recette->setText('test');
        $recette->setPrix(50);
        $recette->setFavoris(true);
        $recette->setDateOfcreation(new DateTimeImmutable());
        $recette->setDateOfmaj(new DateTimeImmutable());




        // $product = new Product();
        $manager->persist($recette);

        $manager->flush();
    }
}
