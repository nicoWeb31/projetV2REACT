<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\Photo;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');



        $pho = new Photo();
        $pho->setUrl($faker->imageUrl($width = 640, $height = 480));
        $manager->persist($pho);

        $pho1 = new Photo();
        $pho1->setUrl($faker->imageUrl($width = 640, $height = 480));
        $manager->persist($pho1);

        $pho2 = new Photo();
        $pho2->setUrl($faker->imageUrl($width = 640, $height = 480));
        $manager->persist($pho2);
        
        $pho3 = new Photo();
        $pho3->setUrl($faker->imageUrl($width = 640, $height = 480));
        $manager->persist($pho3);


        $pho4 = new Photo();
        $pho4->setUrl($faker->imageUrl($width = 640, $height = 480));
        $manager->persist($pho4);


        $pho5 = new Photo();
        $pho5->setUrl($faker->imageUrl($width = 640, $height = 480));
        $manager->persist($pho5);


        $pho6 = new Photo();
        $pho6->setUrl($faker->imageUrl($width = 640, $height = 480));
        $manager->persist($pho6);



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


        for ($i = 0; $i < 5; $i++) {
            $pTrail = new Post();
            $pTrail->setCategory($catergory1)
            ->setContent($faker->paragraph)
            ->setTitle($faker->word)
            ->setSubTitle($faker->word)
            ->setCreatedAt($faker->dateTime());
            $manager->persist($pTrail);
        }

        for ($i = 0; $i < 5; $i++) {
            $pVtt = new Post();
            $pVtt->setCategory($catergory3)
            ->setContent($faker->paragraph)
            ->setTitle($faker->word)
            ->setSubTitle($faker->word)
            ->addPhoto($pho2)
            ->addPhoto($pho6)
            ->addPhoto($pho)
            ->setCreatedAt($faker->dateTime());
            $manager->persist($pVtt);
        }

        for ($i = 0; $i < 5; $i++) {
            $pTrek = new Post();
            $pTrek->setCategory($catergory2)
            ->setContent($faker->paragraph)
            ->setTitle($faker->word)
            ->setSubTitle($faker->word)
            ->addPhoto($pho1)
            ->addPhoto($pho2)
            ->setCreatedAt($faker->dateTime());
            $manager->persist($pTrek);
        }

        for ($i = 0; $i < 5; $i++) {
            $pActu = new Post();
            $pActu->setCategory($catergory4)
            ->setContent($faker->paragraph)
            ->setTitle($faker->word)
            ->setSubTitle($faker->word)
            ->addPhoto($pho5)
            ->setCreatedAt($faker->dateTime());
            $manager->persist($pActu);
        }


        $manager->flush();
    }
}
