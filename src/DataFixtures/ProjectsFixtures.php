<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Project;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProjectsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 5 ; $i++) { 
            $project = new Project();

            $project->setTitle($faker->sentence())
                    ->setDescription($faker->text())
                    ->setCreatedAt($faker->dateTimeBetween('- 6 months'))
                    ->setImage($faker->imageUrl());

            $manager->persist($project);
        }
        $manager->flush();
    }
}
