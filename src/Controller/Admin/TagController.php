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

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TagController
 * @Route("/admin/tag", schemes={"HTTP", "HTTPS"})
 * @package App\Controller\Admin
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class TagController extends AbstractController
{

    /**
     * @Route(path="", name="admin_tag_index", methods={"GET"})
     * @param TagRepository $tagRepository
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(TagRepository $tagRepository)
    {
        return $this->render('admin/tag/index.html.twig', [
            'tags' => $tagRepository->findAll()
        ]);
    }

    /**
     * @Route(path="/new", name="admin_tag_new", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function new(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tag);
            $entityManager->flush();
            return $this->redirectToRoute("admin_tag_index");
        }

        return $this->render("admin/tag/new.html.twig", [
            'tag' => $tag,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route(path="/{id}/edit", name="admin_tag_edit", methods={"GET", "POST"})
     * @param Tag $tag
     * @param Request $request
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function edit(Request $request, Tag $tag)
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render("admin/tag/edit.html.twig", [
            'tag' => $tag,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route(path="/{id}", name="admin_tag_delete", methods={"DELETE"})
     * @param Tag $tag
     * @param Request $request
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function delete(Request $request, Tag $tag)
    {
        if ($this->isCsrfTokenValid("delete" . $tag->getId(), $request->request->get("_token"))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tag);
            $entityManager->flush();
        }

        return $this->redirectToRoute("admin_tag_index");
    }
}
