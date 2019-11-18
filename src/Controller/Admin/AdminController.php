<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Repository\BlogRepository;
use App\Repository\ChallengeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @Route(path="/admin", schemes={"HTTP", "HTTPS"})
 * @package App\Controller\Admin
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class AdminController extends AbstractController
{

    /**
     * @Route(path="", name="admin_index", methods={"GET"})
     * @param BlogRepository $blogRepository
     * @param UserRepository $userRepository
     * @param ChallengeRepository $challengeRepository
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(
        BlogRepository $blogRepository,
        UserRepository $userRepository,
        ChallengeRepository $challengeRepository
    ): Response
    {
        return $this->render('admin/index.html.twig', [
            'blog_count' => $blogRepository->count([]),
            'user_count' => $userRepository->count([]),
            'challenge_count' => $challengeRepository->count([]),
            'challenges' => $challengeRepository->findLatest(5)
        ]);
    }
}
