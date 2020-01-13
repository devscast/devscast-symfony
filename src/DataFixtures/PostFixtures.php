<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = $manager
            ->getRepository(User::class)
            ->findOneBy(['email' => 'admin@devs-cast.com']);

        if ($user) {
            $faker = Factory::create('fr_FR');
            for ($i = 0; $i < 100; $i++) {
                $blog = new Post();
                $blog
                    ->setName($faker->words(4, true))
                    ->setContent($faker->sentences(3, true))
                    ->setCreatedAt(new \DateTime("now"))
                    ->setIsOnline(true)
                    ->setDuration(mt_rand(0, 60))
                    ->setDescription($faker->sentences(1, true))
                    ->setThumbUrl("default.jpg")
                    ->setIsArchived(0)
                    ->setVideoUrl(uniqid())
                    ->setSlug($faker->slug)
                    ->setUser($user);
                $manager->persist($blog);
            }

            $manager->flush();
        } else {
            throw new \LogicException("default User doesn't exist, please create one by running UserFixtures");
        }
    }
}
