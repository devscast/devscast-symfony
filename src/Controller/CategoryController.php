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

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class CategoryController
 * @Route("/categories", schemes={"HTTP", "HTTPS"})
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class CategoryController extends AbstractController
{

    /**
     * @Route(
     *     path="/{slug}-{id}",
     *     name="app_category_show",
     *     methods={"GET"},
     *     requirements={"slug":"[a-z0-9-]+", "id":"[\d]+"}
     * )
     * @param Category $category
     * @param string $slug
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function show(Category $category, string $slug): Response
    {
        if ($category->getSlug() !== $slug) {
            return $this->redirectToRoute("app_category_show", [
                'id' => $category->getId(),
                'slug' => $category->getSlug()
            ], Response::HTTP_MOVED_PERMANENTLY);
        }
        return $this->render('app/blog/show.html.twig', [
            'posts' => $category->getPosts(),
            'blogs' => $category->getBlogs()
        ]);
    }
}
