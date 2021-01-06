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

namespace App\Security\Voter;

use App\Entity\Tag;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TagVoter
 * @package App\Security\Voter
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class TagVoter extends Voter
{
    public const CREATE = 'TAG_CREATE';
    public const EDIT = 'TAG_EDIT';
    public const VIEW = 'TAG_VIEW';
    public const DELETE = 'TAG_DELETE';
    private Security $security;

    /**
     * @param Security $security
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param string $attribute
     * @param Tag $subject
     * @return bool
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE]) && $subject instanceof Tag;
    }

    /**
     * @param string $attribute
     * @param Tag $subject
     * @param TokenInterface $token
     * @return bool
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted("ROLE_SUPER_ADMIN")) {
            return true;
        }

        switch ($attribute) {
            case self::CREATE:
                return false;

            case self::EDIT:
            case self::VIEW:
            case self::DELETE:
                return !$subject->getIsArchived();
        }

        return false;
    }
}
