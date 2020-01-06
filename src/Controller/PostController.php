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

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostController
 * @Route("/videos", schemes={"HTTP", "HTTPS"})
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class PostController extends AbstractController
{

    /**
     * @Route(path="", name="app_post_index", methods={"GET"})
     * @param PostRepository $postRepository
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render("app/blog/index.html.twig", [
            'posts' => $postRepository->findAll(),
            'data_type' => 'post'
        ]);
    }

    /**
     * @Route(
     *     path="/{slug}-{id}",
     *     name="app_post_show",
     *     methods={"GET"},
     *     requirements={"slug":"[a-z0-9-]+", "id":"[\d]+"}
     * )
     * @param Post $post
     * @param string $slug
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function show(Post $post, string $slug): Response
    {
        if ($post->getSlug() !== $slug) {
            return $this->redirectToRoute("app_blog_show", [
                'id' => $post->getId(),
                'slug' => $post->getSlug()
            ], Response::HTTP_MOVED_PERMANENTLY);
        }
        return $this->render('app/blog/show.html.twig', [
            'post' => $post,
            'data_type' => 'post'
        ]);
    }
}
