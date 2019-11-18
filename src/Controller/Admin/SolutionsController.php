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

use App\Entity\Solutions;
use App\Form\SolutionsType;
use App\Repository\SolutionsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SolutionsController
 * @Route("/admin/solutions", schemes={"HTTP", "HTTPS"})
 * @package App\Controller\Admin
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class SolutionsController extends AbstractController
{
    /**
     * @Route("", name="admin_solutions_index", methods={"GET"})
     * @param SolutionsRepository $solutionsRepository
     * @return Response
     */
    public function index(SolutionsRepository $solutionsRepository): Response
    {
        return $this->render('admin/solutions/index.html.twig', [
            'solutions' => $solutionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_solutions_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $solution = new Solutions();
        $form = $this->createForm(SolutionsType::class, $solution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($solution);
            $entityManager->flush();

            return $this->redirectToRoute('admin_solutions_index');
        }

        return $this->render('admin/solutions/new.html.twig', [
            'solution' => $solution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_solutions_show", methods={"GET"})
     * @param Solutions $solution
     * @return Response
     */
    public function show(Solutions $solution): Response
    {
        return $this->render('admin/solutions/show.html.twig', [
            'solution' => $solution,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_solutions_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Solutions $solution
     * @return Response
     * @throws \Exception
     */
    public function edit(Request $request, Solutions $solution): Response
    {
        $form = $this->createForm(SolutionsType::class, $solution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $solution->setUpdatedAt(new DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_solutions_index');
        }

        return $this->render('admin/solutions/edit.html.twig', [
            'solution' => $solution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_solutions_delete", methods={"DELETE"})
     * @param Request $request
     * @param Solutions $solution
     * @return Response
     */
    public function delete(Request $request, Solutions $solution): Response
    {
        if ($this->isCsrfTokenValid('delete'.$solution->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($solution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_solutions_index');
    }
}
