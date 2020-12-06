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

namespace App\Controller\Admin;

use App\Entity\GlobalMessage;
use App\Form\GlobalMessageForm;
use App\Repository\GlobalMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GlobalMessageController
 * @Route("/admin/message", schemes={"HTTP", "HTTPS"})
 * @package App\Controller\Admin
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class GlobalMessageController extends AbstractController
{
    /**
     * @Route("", name="admin_message_index", methods={"GET"})
     * @param GlobalMessageRepository $globalMessageRepository
     * @return Response
     */
    public function index(GlobalMessageRepository $globalMessageRepository): Response
    {
        return $this->render('admin/message/index.html.twig', [
            'global_messages' => $globalMessageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_message_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $globalMessage = new GlobalMessage();
        $form = $this->createForm(GlobalMessageForm::class, $globalMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($globalMessage);
            $entityManager->flush();
            return $this->redirectToRoute('admin_message_index');
        }

        return $this->render('admin/message/new.html.twig', [
            'global_message' => $globalMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_message_edit", methods={"GET","POST"})
     * @param Request $request
     * @param GlobalMessage $globalMessage
     * @return Response
     */
    public function edit(Request $request, GlobalMessage $globalMessage): Response
    {
        $form = $this->createForm(GlobalMessageForm::class, $globalMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_message_index');
        }

        return $this->render('admin/message/edit.html.twig', [
            'global_message' => $globalMessage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_message_delete", methods={"DELETE"})
     * @param Request $request
     * @param GlobalMessage $globalMessage
     * @return Response
     */
    public function delete(Request $request, GlobalMessage $globalMessage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $globalMessage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $globalMessage->setState(!boolval($globalMessage->getState()));
            $entityManager->persist($globalMessage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_message_index');
    }
}
