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

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BlogController
 * @Route("/blog", schemes={"HTTP","HTTPS"})
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class BlogController extends AbstractController
{

    /** @var BlogRepository */
    private $repository;

    /**
     * BlogController constructor.
     * @param BlogRepository $repository
     */
    public function __construct(BlogRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route(path="", name="app_blog_index", methods={"GET"})
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index()
    {
        return $this->render(
            'app/blog/index.html.twig', [
                'blogs' => $this->repository->findAll()
            ]
        );
    }

    /**
     * @Route(
     *     path="/{slug}-{id}",
     *     name="app_blog_show",
     *     methods={"GET"},
     *     requirements={"slug":"[a-z0-9-]+", "id":"[\d]+"}
     * )
     * @param Blog $blog
     * @param string $slug
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function show(Blog $blog, string $slug)
    {
        if ($blog->getSlug() !== $slug) {
            return $this->redirectToRoute("app_blog_show", [
                'id' => $blog->getId(),
                'slug' => $blog->getSlug()
            ], Response::HTTP_MOVED_PERMANENTLY);
        }
        return $this->render('app/blog/show.html.twig', compact('blog'));
    }
}
