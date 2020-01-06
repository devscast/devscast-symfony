<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/tags", schemes={"HTTP", "HTTPS"})
 * Class TagController
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class TagController extends AbstractController
{

    /**
     * @Route(
     *     path="/{id}",
     *     name="app_tag_show",
     *     methods={"GET"},
     *     requirements={"slug":"[a-z0-9-]+", "id":"[\d]+"}
     * )
     * @param Tag $tag
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function show(Tag $tag): Response
    {
        return $this->render('app/category/show.html.twig', [
            'posts' => $tag->getPosts(),
            'blogs' => $tag->getBlogs(),
        ]);
    }
}

