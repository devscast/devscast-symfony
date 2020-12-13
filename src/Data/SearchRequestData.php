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

/**
 * Class SearchData
 * @package App\Data
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class SearchRequestData
{
    public string $q = '';

    public string $category = 'blog';

    public ?int $page = 1;
}
