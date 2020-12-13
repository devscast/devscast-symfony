<?php

declare(strict_types=1);

namespace App\Controller;

use App\Data\ViewData;
use DateTimeImmutable;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * Trait XhrHttpRequestTrait
 * @package App\Http\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
trait XhrHttpRequestTrait
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function xhrNew(Request $request): JsonResponse
    {
        $item = $this->entity;
        $item = new $item();
        $form = $this->createForm($this->form, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (property_exists($item, "slug")) {
                $slugger = new AsciiSlugger();
                $item->setSlug($slugger->slug(strtolower($item->getName()))->toString());
            }

            $this->em->persist($item);
            $this->em->flush();

            if ($this->events['created'] !== null) {
                $this->dispatcher->dispatch(new $this->events['created']($item));
            }
            return new JsonResponse(null, Response::HTTP_CREATED);
        }

        $vm = ViewData::createForMutation($this->domain, $form->createView(), $item);
        return new JsonResponse([
            'html' => $this->renderView($this->views['new'], compact('vm'))
        ], $this->getResponseCodeFromValidation($form));
    }

    /**
     * @param Request $request
     * @param object $item
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function xhrEdit(Request $request, object $item): Response
    {
        $oldItem = clone $item;
        $form = $this->createForm($this->form, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (property_exists($item, "updated_at")) {
                $item->setUpdatedAt(new DateTimeImmutable());
            }

            if (property_exists($item, "slug")) {
                $slugger = new AsciiSlugger();
                $item->setSlug($slugger->slug(strtolower($item->getName()))->toString());
            }

            $this->em->flush();
            if ($this->events['edited'] !== null) {
                $this->dispatcher->dispatch(new $this->events['edit']($oldItem, $item));
            }
            return new JsonResponse(null, Response::HTTP_CREATED);
        }

        $vm = ViewData::createForMutation($this->domain, $form->createView(), $item);
        return new JsonResponse([
            'html' => $this->renderView($this->views['edit'], compact('vm'))
        ], $this->getResponseCodeFromValidation($form));
    }

    /**
     * @param Request $request
     * @param object $item
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function xhrDelete(Request $request, object $item): Response
    {
        $data = json_decode($request->getContent());
        if ($this->isCsrfTokenValid('delete' . $item->getId(), $data->_token)) {
            $this->em->remove($item);
            $this->em->flush();

            if ($this->events['deleted'] !== null) {
                $this->dispatcher->dispatch(new $this->events['deleted']($item));
            }
            return new JsonResponse(null, Response::HTTP_ACCEPTED);
        }
        return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param FormInterface $form
     * @return int
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getResponseCodeFromValidation(FormInterface $form): int
    {
        if ($form->isSubmitted() && !$form->isValid()) {
            return Response::HTTP_UNPROCESSABLE_ENTITY;
        }
        return Response::HTTP_OK;
    }
}
