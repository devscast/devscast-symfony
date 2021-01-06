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

namespace App\Controller\Backend;

use App\Controller\CrudController;
use App\Data\ViewData;
use App\Entity\Post;
use App\Form\PostForm;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_CONTENT_MANAGER")
 * Class Post Controller
 * @Route("/backend/post", name="backend_post_")
 * @package App\Controller\Backend
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class PostController extends CrudController
{

    protected string $domain = 'post';
    protected string $entity = Post ::class;
    protected string $form = PostForm::class;
    protected const FILTERABLE_FIELDS = [
        'item.name' => 'Name',
    ];
    protected array $views = [
        'index' => '@backend/post/index.html.twig',
        'show' => '@backend/post/show.html.twig',
        'edit' => '@layout/backend/_form.html.twig',
        'new' => '@layout/backend/_form.html.twig',
    ];
    protected array $events = [
        'created' => null,
        'edited' => null,
        'deleted' => null
    ];

    /**
     * @Route("", name="index", methods={"GET"})
     * @param Request $request
     * @param QueryBuilder|null $qb
     * @return Response
     */
    public function index(Request $request, ?QueryBuilder $qb = null): Response
    {
        return parent::index($request);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        return $this->xhrNew($request);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Post $item
     * @return Response
     */
    public function show(Post $item): Response
    {
        $this->denyAccessUnlessGranted("POST_VIEW", $item);
        $vm = new viewData($this->domain, $item);
        return $this->render($this->views['show'], compact('vm'));
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Post $item
     * @return Response
     */
    public function edit(Request $request, Post $item): Response
    {
        $this->denyAccessUnlessGranted("POST_EDIT", $item);
        return $this->xhrEdit($request, $item);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Post $item
     * @return Response
     */
    public function delete(Request $request, Post $item): Response
    {
        $this->denyAccessUnlessGranted("POST_DELETE", $item);
        return $this->xhrDelete($request, $item);
    }
}
