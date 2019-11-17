<?php

namespace App\Controller\Admin;

use App\Repository\BlogRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @Route(path="/admin")
 * @package App\Controller\Admin
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class AdminController extends AbstractController
{

    /**
     * @Route(path="", name="admin_index", methods={"GET"})
     * @param BlogRepository $blogRepository
     * @param UserRepository $userRepository
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(BlogRepository $blogRepository, UserRepository $userRepository): Response
    {
        $blog_count = $blogRepository->count([]);
        $user_count = $userRepository->count([]);
        return $this->render('admin/index.html.twig', [
            'blog_count' => $blog_count,
            'user_count' => $user_count
        ]);
    }
}
