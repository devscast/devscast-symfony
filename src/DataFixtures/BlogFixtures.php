<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class BlogFixtures
 * @package App\DataFixtures
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class BlogFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        if ($_ENV['APP_ENV'] === 'dev') {
            $user = $manager
                ->getRepository(User::class)
                ->findOneBy(['email' => 'admin@devs-cast.com']);

            if ($user) {
                $faker = Factory::create('fr_FR');
                for ($i = 0; $i < 100; $i++) {
                    $blog = new Blog();
                    $blog
                        ->setName($faker->words(4, true))
                        ->setContent($faker->sentences(3, true))
                        ->setCreatedAt(new \DateTime("now"))
                        ->setIsOnline(true)
                        ->setThumbUrl("default.jpg")
                        ->setIsArchived(0)
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
}
