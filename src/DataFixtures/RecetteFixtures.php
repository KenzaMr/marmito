<?php

namespace App\DataFixtures;

use App\Entity\Recette;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecetteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=\Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));
        for ($i=0; $i < 15; $i++) { 
            $recette=new Recette();
            $recette->setName($faker->vegetableName());
            $recette->setPrice($faker->randomDigit());
            $recette->setDateOfCreation(new DateTimeImmutable());
            $manager->persist($recette);
        }

        $manager->flush();
    }
}
