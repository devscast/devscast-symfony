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

use App\Entity\User;
use Faker\Factory;
use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class BlogFixtures
 * @package App\DataFixtures
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class BlogFixtures extends Fixture
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
