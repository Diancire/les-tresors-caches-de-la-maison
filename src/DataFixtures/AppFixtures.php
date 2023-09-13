<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i=0; $i < 50; $i++) {
            $article = new Article;
            $article->setTitle($faker->words(4, true))
                    ->setContent($faker->realText(1800))
                    ->setState(mt_rand(0,2) === 1 ? 'STATE_DRAFT' : 'STATE_PUBLISHED');

            $manager->persist($article);

        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
