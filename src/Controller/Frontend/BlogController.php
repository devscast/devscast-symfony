<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @Route("/blog", name="app_blog_")
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class BlogController extends AbstractController
{
    private BlogRepository $repository;

    /**
     * BlogController constructor.
     * @param BlogRepository $repository
     */
    public function __construct(BlogRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route(path="", name="index", methods={"GET"})
     * @param Request $request
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(Request $request): Response
    {
        return $this->render("@frontend/blog/index.html.twig", [
            'blogs' => $this->repository->findPaginated(
                $request->query->getInt('page', 1)
            ),
            'data_type' => 'blog'
        ]);
    }

    /**
     * @Route(
     *     path="/{slug}-{id}",
     *     name="show",
     *     methods={"GET"},
     *     requirements={"slug":"[a-z0-9-]+", "id":"[\d]+"}
     * )
     * @param Blog $blog
     * @param string $slug
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function show(Blog $blog, string $slug): Response
    {
        if ($blog->getSlug() !== $slug) {
            return $this->redirectToRoute("app_blog_show", [
                'id' => $blog->getId(),
                'slug' => $blog->getSlug()
            ], Response::HTTP_MOVED_PERMANENTLY);
        }
        return $this->render('@frontend/blog/show.html.twig', [
            'blog' => $blog,
            'data_type' => 'blog'
        ]);
    }
}
