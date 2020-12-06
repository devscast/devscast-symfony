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

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ContactData
 * @package App\Data
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ContactRequestData
{

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="180")
     */
    public ?string $name = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public ?string $email = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="255")
     */
    public ?string $subject = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="10")
     */
    public ?string $message = null;
}
