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

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @Route("/admin/blog", schemes={"HTTP", "HTTPS"})
 * @package App\Controller\Admin
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class BlogController extends AbstractController
{
    /**
     * @Route("", name="admin_blog_index", methods={"GET"})
     * @param BlogRepository $blogRepository
     * @return Response
     */
    public function index(BlogRepository $blogRepository): Response
    {
        return $this->render('admin/blog/index.html.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_blog_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $blog = new Blog();
        $blog->setUser($this->getUser());
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();
            return $this->redirectToRoute('admin_blog_index');
        }

        return $this->render('admin/blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_blog_show", methods={"GET"})
     * @param Blog $blog
     * @return Response
     */
    public function show(Blog $blog): Response
    {
        return $this->render('admin/blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_blog_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Blog $blog
     * @return Response
     * @throws Exception
     */
    public function edit(Request $request, Blog $blog): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blog->setUpdatedAt(new DateTime());
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_blog_index');
        }

        return $this->render('admin/blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_blog_delete", methods={"DELETE"})
     * @param Request $request
     * @param Blog $blog
     * @return Response
     */
    public function delete(Request $request, Blog $blog): Response
    {
        if ($this->isCsrfTokenValid('delete' . $blog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_blog_index');
    }
}
