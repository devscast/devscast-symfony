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

/**
 * Class ResetPasswordData
 * @package App\Data
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ResetPasswordData
{

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public ?string $email = null;
}
