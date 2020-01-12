<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

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
                (new Tag())->setName($tag)
            );
        }

        $manager->flush();
    }
}
