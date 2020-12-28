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

use App\Entity\Post;
use App\Data\SearchRequestData;
use App\Form\SearchForm;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class PostController
 * @Route("/videos", name="app_post_")
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class PostController extends AbstractController
{

    private PostRepository $postRepository;

    /**
     * PostController constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route(path="", name="index", methods={"GET"})
     * @param Request $request
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(Request $request): Response
    {
        return $this->render("@frontend/posts/index.html.twig", [
            'posts' => $this->postRepository->findPaginated(
                $request->query->getInt('page', 1)
            ),
            'data_type' => 'post'
        ]);
    }

    /**
     * @Route(
     *     path="/{slug}-{id}",
     *     name="show",
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
            return $this->redirectToRoute("app_post_show", [
                'id' => $post->getId(),
                'slug' => $post->getSlug()
            ], Response::HTTP_MOVED_PERMANENTLY);
        }
        return $this->render('@frontend/posts/show.html.twig', [
            'post' => $post,
            'posts' => $this->postRepository->findForSidebar(),
            'data_type' => 'post'
        ]);
    }

    /**
     * @Route(path="/search", name="search", methods={"GET"})
     * @param Request $request
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function search(Request $request): Response
    {
        $data = new SearchRequestData();
        $searchForm = $this->createForm(SearchForm::class, $data);
        $searchForm->handleRequest($request);

        if (!is_null($data->q)) {
            return $this->render("@frontend/blog/search.html.twig", [
                'posts' => $this->postRepository->findSearch($data),
                'data_type' => 'post'
            ]);
        }
        return $this->redirectToRoute('app_post_index');
    }
}
