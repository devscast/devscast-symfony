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
use App\Entity\Tag;
use App\Form\TagForm;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_CONTENT_MANAGER")
 * Class TagController
 * @Route("/backend/tag", name="backend_tag_")
 * @package App\Controller\Backend
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class TagController extends CrudController
{

    protected string $domain = 'tag';
    protected string $entity = Tag::class;
    protected string $form = TagForm::class;
    protected const FILTERABLE_FIELDS = [
        'item.name' => 'Name',
    ];
    protected array $views = [
        'index' => '@backend/tag/index.html.twig',
        'edit' => '@layout/backend/_form.html.twig',
        'new' => '@layout/backend/_form.html.twig',
    ];
    protected array $events = [
        'created' => null,
        'edited' => null,
        'deleted' => null
    ];
    protected array $options = [
        'show' => false
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
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Tag $item
     * @return Response
     */
    public function edit(Request $request, Tag $item): Response
    {
        $this->denyAccessUnlessGranted("TAG_EDIT", $item);
        return $this->xhrEdit($request, $item);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Tag $item
     * @return Response
     */
    public function delete(Request $request, Tag $item): Response
    {
        $this->denyAccessUnlessGranted("TAG_DELETE", $item);
        return $this->xhrDelete($request, $item);
    }
}
