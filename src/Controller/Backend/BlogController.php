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
use App\Entity\Blog;
use App\Form\BlogForm;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_CONTENT_MANAGER")
 * Class BlogController
 * @Route("/backend/blog", name="backend_blog_")
 * @package App\Controller\Backend
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class BlogController extends CrudController
{

    protected string $domain = 'blog';
    protected string $entity = Blog::class;
    protected string $form = BlogForm::class;
    protected const FILTERABLE_FIELDS = [
        'item.name' => 'Name',
    ];
    protected array $views = [
        'index' => '@backend/blog/index.html.twig',
        'show' => '@backend/blog/show.html.twig',
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
     * @return Response
     */
    public function new(Request $request): Response
    {
        return $this->xhrNew($request);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Blog $item
     * @return Response
     */
    public function show(Blog $item): Response
    {
        $this->denyAccessUnlessGranted("BLOG_VIEW", $item);
        $vm = new viewData($this->domain, $item);
        return $this->render($this->views['show'], compact('vm'));
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Blog $item
     * @return Response
     */
    public function edit(Request $request, Blog $item): Response
    {
        $this->denyAccessUnlessGranted("BLOG_EDIT", $item);
        return $this->xhrEdit($request, $item);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Blog $item
     * @return Response
     */
    public function delete(Request $request, Blog $item): Response
    {
        $this->denyAccessUnlessGranted("BLOG_DELETE", $item);
        return $this->xhrDelete($request, $item);
    }
}
