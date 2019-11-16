<?php

namespace App\Controller\Admin;

use App\Repository\BlogRepository;
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
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(BlogRepository $blogRepository): Response
    {
        $blog_count = $blogRepository->count([]);
        return $this->render('admin/index.html.twig', [
            'blog_count' => $blog_count
        ]);
    }
}
