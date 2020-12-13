<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Backend;

use App\Controller\CrudController;
use App\Data\ViewData;
use App\Entity\User;
use App\Form\UserForm;
use DateTimeImmutable;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_SUPER_ADMIN")
 * Class UserController
 * @Route("/backend/user", name="backend_user_")
 * @package App\Controller\Backend
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class UserController extends CrudController
{
    protected string $domain = 'user';
    protected string $entity = User::class;
    protected string $form = UserForm::class;
    protected const FILTERABLE_FIELDS = [
        'item.email' => 'Email',
        'item.name' => 'Name'
    ];
    protected array $views = [
        'index' => '@backend/user/index.html.twig',
        'show' => '@backend/user/show.html.twig',
        'edit' => '@backend/user/forms.html.twig',
        'new' => '@backend/user/forms.html.twig',
    ];
    protected array $events = [
        'created' => null,
        'edited' => null,
        'deleted' => null
    ];

    /**
     * @Route("", name="index", methods={"GET"})
     * @param Request $request
     * @param QueryBuilder|null $builder
     * @return Response
     */
    public function index(Request $request, ?QueryBuilder $builder = null): Response
    {
        return parent::index($request);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): JsonResponse
    {
        $item = new User();
        $form = $this->createForm($this->form, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item->setPassword($encoder->encodePassword($item, $form->get('password')->getData()));
            $this->em->persist($item);
            $this->em->flush();
            return new JsonResponse(null, Response::HTTP_CREATED);
        }

        $vm = ViewData::createForMutation($this->domain, $form->createView(), $item);
        return new JsonResponse([
            'html' => $this->renderView($this->views['new'], compact('vm'))
        ], $this->getResponseCodeFromValidation($form));
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param User $item
     * @return Response
     */
    public function show(User $item): Response
    {
        $vm = new viewData($this->domain, $item);
        return $this->render($this->views['show'], compact('vm'));
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $item
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function edit(Request $request, User $item, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm($this->form, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item
                ->setPassword($encoder->encodePassword($item, $form->get('password')->getData()))
                ->setUpdatedAt(new DateTimeImmutable());
            $this->em->flush();
            return new JsonResponse([], Response::HTTP_CREATED);
        }

        $vm = ViewData::createForMutation($this->domain, $form->createView(), $item);
        return new JsonResponse([
            'html' => $this->renderView($this->views['new'], compact('vm'))
        ], $this->getResponseCodeFromValidation($form));
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param User $item
     * @return Response
     */
    public function delete(Request $request, User $item): Response
    {
        return $this->xhrDelete($request, $item);
    }
}
