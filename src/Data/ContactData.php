<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Data;

use Symfony\Component\Validator\Constraints as Assert;

class ContactData
{

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="180")
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="255")
     */
    public $subject;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="10")
     */
    public $message;
}
