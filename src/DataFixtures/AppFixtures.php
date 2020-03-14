<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        $catergory1 = new Category();
        $catergory1->setName('Trail');
        $manager->persist($catergory1);

        $catergory2 = new Category();
        $catergory2->setName('Trek');
        $manager->persist($catergory2);

        $catergory3 = new Category();
        $catergory3->setName('Vtt');
        $manager->persist($catergory3);

        $catergory4 = new Category();
        $catergory4->setName('Actu');
        $manager->persist($catergory4);


        for ($i = 0; $i < 10; $i++) {
            $pTrail = new Post();
            $pTrail->setCategory($catergory1)
            ->setContent($faker->paragraph)
            ->setTitle($faker->word)
            ->setSubTitle($faker->word)
            ->setCreatedAt($faker->dateTime());
            $manager->persist($pTrail);
        }

        for ($i = 0; $i < 10; $i++) {
            $pVtt = new Post();
            $pVtt->setCategory($catergory3)
            ->setContent($faker->paragraph)
            ->setTitle($faker->word)
            ->setSubTitle($faker->word)
            ->setCreatedAt($faker->dateTime());
            $manager->persist($pVtt);
        }

        for ($i = 0; $i < 10; $i++) {
            $pTrek = new Post();
            $pTrek->setCategory($catergory2)
            ->setContent($faker->paragraph)
            ->setTitle($faker->word)
            ->setSubTitle($faker->word)
            ->setCreatedAt($faker->dateTime());
            $manager->persist($pTrek);
        }

        for ($i = 0; $i < 10; $i++) {
            $pActu = new Post();
            $pActu->setCategory($catergory4)
            ->setContent($faker->paragraph)
            ->setTitle($faker->word)
            ->setSubTitle($faker->word)
            ->setCreatedAt($faker->dateTime());
            $manager->persist($pActu);
        }


        $manager->flush();
    }
}
