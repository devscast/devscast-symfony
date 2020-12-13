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

namespace App\Data;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use Symfony\Component\Form\FormView;

/**
 * Class DomainData
 * @package App\Http\DataTransfert
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ViewData
{
    public string $name;
    public string $formattedName;
    public string $formattedVoterRoot;
    public FormView $form;
    public array $forms = [];
    public array $routes;
    public array $voters = [];
    public array $options = [
        'pagination' => false,
        'search' => false,
        'search_filters' => [],
        'stats' => false,
        'show' => true,
        'create' => true,
        'delete' => true,
        'edit' => true
    ];

    /** @var object|array|SlidingPaginationInterface */
    public $data;

    /**
     * Module constructor.
     * @param string $name
     * @param array|object|null $data
     * @param array $options
     * @param string $prefix
     */
    public function __construct(string $name, $data = null, array $options = [], $prefix = 'backend')
    {
        $this->name = $name;
        $this->data = $data;
        $this->routes = [
            'new' => "{$prefix}_{$name}_new",
            'index' => "{$prefix}_{$name}_index",
            'show' => "{$prefix}_{$name}_show",
            'edit' => "{$prefix}_{$name}_edit",
            'delete' => "{$prefix}_{$name}_delete"
        ];
        $this->options = array_merge($this->options, $options);
        $this->formattedName = implode(" ", explode(".", $name));
        $this->formattedVoterRoot = strtoupper(implode("_", explode(".", $name)));

        $this->voters = [
            'new' => "{$this->formattedVoterRoot}_CREATE",
            'index' => "{$this->formattedVoterRoot}_LIST",
            'show' => "{$this->formattedVoterRoot}_VIEW",
            'edit' => "{$this->formattedVoterRoot}_EDIT",
            'delete' => "{$this->formattedVoterRoot}_DELETE"
        ];

        if ($data instanceof SlidingPaginationInterface) {
            $this->options['pagination'] = true;

            if (!empty($this->options['search_filters'])) {
                $this->options['search'] = true;
            }
        }
    }

    /**
     * @param string $name
     * @param FormView $form
     * @param null $data
     * @param array|null $options
     * @return static
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public static function createForMutation(string $name, FormView $form, $data = null, array $options = []): self
    {
        $data = new ViewData($name, $data, $options);
        $data->form = $form;
        return $data;
    }
}
