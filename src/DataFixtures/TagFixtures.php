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

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TagFixtures
 * @package App\DataFixtures
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tags = [
            'php',
            'backend',
            'frontend',
            'javascript',
            'html-css',
            'security',
            'web',
            'algorithme',
            'astuce',
            'tutoriel',
            'news',
            'librairie'
        ];

        foreach ($tags as $tag) {
            $manager->persist(
                (new Tag())->setName($tag)->setIsArchived(0)
            );
        }

        $manager->flush();
    }
}
