<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class PostFixtures
 * @package App\DataFixtures
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class PostFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function load(ObjectManager $manager)
    {
        if ($_ENV['APP_ENV'] === 'dev') {

            /** @var User|null $user */
            $user = $manager
                ->getRepository(User::class)
                ->findOneBy(['email' => 'admin@devs-cast.com']);

            if ($user) {
                $faker = Factory::create('fr_FR');
                for ($i = 0; $i < 100; $i++) {
                    $post = new Post();
                    $post
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
                    $manager->persist($post);
                }

                $manager->flush();
            } else {
                throw new \LogicException("default User doesn't exist, please create one by running UserFixtures");
            }
        }
    }
}
