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

namespace App\Controller;

use App\Data\ViewData;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CrudController
 * @package App\Http\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
abstract class CrudController extends AbstractController
{
    use XhrHttpRequestTrait;

    protected string $domain = '';
    protected string $entity = '';
    protected string $form = '';
    protected const FILTERABLE_FIELDS = [];
    protected array $views = [
        'index' => null,
        'show' => null,
        'edit' => '@layout/backend/_form.html.twig',
        'new' => '@layout/backend/_form.html.twig',
    ];
    protected array $events = [
        'created' => null,
        'edited' => null,
        'deleted' => null
    ];
    protected array $options = [
        'stats' => false,
        'show' => true,
        'create' => true,
        'delete' => true,
        'edit' => true
    ];

    protected EntityManagerInterface $em;
    protected EventDispatcherInterface $dispatcher;
    protected PaginatorInterface $paginator;

    /**
     * CrudController constructor.
     * @param EntityManagerInterface $em
     * @param EventDispatcherInterface $dispatcher
     * @param PaginatorInterface $paginator
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __construct(
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatcher,
        PaginatorInterface $paginator
    ) {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->paginator = $paginator;
    }

    /**
     * @param Request $request
     * @param QueryBuilder|null $qb
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(Request $request, ?QueryBuilder $qb = null): Response
    {
        $page = $request->query->getInt('page', 1);
        $field = $request->query->get('filterField', '');
        $value = $request->query->get('filterValue', '');

        if (!$qb) {
            $qb = $this->em->createQueryBuilder();
            $qb->from($this->entity, 'item')->select('item');
        }

        if ($value && $field && in_array($field, array_keys(static::FILTERABLE_FIELDS))) {
            $qb->andWhere("{$field} LIKE :query")->setParameter("query", "%{$value}%");
        }

        $items = $this->paginator->paginate($qb->orderBy("item.id", "DESC"), $page, 50);
        $vm = new ViewData($this->domain, $items, [...$this->options, ['search_filters' => static::FILTERABLE_FIELDS]]);
        return $this->render($this->views['index'], compact('vm'));
    }
}
