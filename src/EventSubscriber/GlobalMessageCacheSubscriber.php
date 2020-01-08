<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;


use App\Entity\GlobalMessage;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

/**
 * Class GlobalMessageCacheSubscriber
 * @package App\EventSubscriber
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class GlobalMessageCacheSubscriber implements EventSubscriber
{

    /** @var TagAwareAdapterInterface */
    private $cache;

    /**
     * GlobalMessageCacheSubscriber constructor.
     * @param TagAwareAdapterInterface $cache
     */
    public function __construct(TagAwareAdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [
            'preUpdate',
        ];
    }

    /**
     * @param PreUpdateEventArgs $args
     * @throws \Psr\Cache\InvalidArgumentException
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        if ($args->getEntity() instanceof GlobalMessage) {
            $this->cache->deleteItem("message");
        }
    }
}
