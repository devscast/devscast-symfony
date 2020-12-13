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

namespace App\Controller\Backend;

use App\Repository\BlogRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @Route(path="/backend")
 * @package App\Controller\Backend
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class MainController extends AbstractController
{

    /**
     * @Route(path="", name="backend_index", methods={"GET"})
     * @param BlogRepository $blogRepository
     * @param PostRepository $postRepository
     * @param UserRepository $userRepository
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(
        BlogRepository $blogRepository,
        PostRepository $postRepository,
        UserRepository $userRepository
    ): Response {
        return $this->render('@backend/index.html.twig', [
            'blog_count' => $blogRepository->count([]),
            'post_count' => $postRepository->count([]),
            'user_count' => $userRepository->count([]),
        ]);
    }
}
