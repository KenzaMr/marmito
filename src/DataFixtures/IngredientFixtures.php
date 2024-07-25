<?php

namespace App\DataFixtures;

use App\Entity\Ingredients;
use App\Entity\Recette;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=\Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));
        for ($i=0; $i < 15; $i++) { 
            $recette=new Ingredients();
            $recette->setName($faker->vegetableName());
            $recette->setPrice($faker->randomDigit());
            $recette->setDateOfCreation(new DateTimeImmutable());
            $manager->persist($recette);
            $this->addReference('INGREDIENT'.$i,$recette);
        }

        $manager->flush();
    }
}
