<?php

namespace App\Controller\Admin;

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
     * @Route(path="/", name="admin.index", methods={"GET"})
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(): Response
    {
        return new Response("Admin page");
    }
}
