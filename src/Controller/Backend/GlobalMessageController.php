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
use App\Entity\GlobalMessage;
use App\Form\GlobalMessageForm;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_CONTENT_MANAGER")
 * Class GlobalMessageController
 * @Route("/backend/message", name="backend_message_")
 * @package App\Controller\Backend
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class GlobalMessageController extends CrudController
{
    protected string $domain = 'message';
    protected string $entity = GlobalMessage::class;
    protected string $form = GlobalMessageForm::class;
    protected const FILTERABLE_FIELDS = [];
    protected array $views = [
        'index' => '@backend/message/index.html.twig',
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
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param GlobalMessage $item
     * @return Response
     */
    public function edit(Request $request, GlobalMessage $item): Response
    {
        $this->denyAccessUnlessGranted("MESSAGE_EDIT", $item);
        return $this->xhrEdit($request, $item);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param GlobalMessage $item
     * @return Response
     */
    public function delete(Request $request, GlobalMessage $item): Response
    {
        $this->denyAccessUnlessGranted("MESSAGE_DELETE", $item);
        return $this->xhrDelete($request, $item);
    }
}
