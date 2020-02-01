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

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Exception;
use App\Entity\Tag;
use App\Entity\Post;
use App\Entity\Category;
use Psr\Log\LoggerInterface;
use App\Entity\GlobalMessage;
use Doctrine\Common\EventSubscriber;
use Psr\Cache\InvalidArgumentException;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

/**
 * Class ContentCacheSubscriber
 * @package App\EventSubscriber
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ContentCacheSubscriber implements EventSubscriber
{

    private TagAwareAdapterInterface $cache;

    private LoggerInterface $logger;

    /**
     * ContentCacheSubscriber constructor.
     * @param TagAwareAdapterInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(TagAwareAdapterInterface $cache, LoggerInterface $logger)
    {
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents(): array
    {
        return [
            'preUpdate',
            'preRemove',
            'prePersist'
        ];
    }

    /**
     * @param PreUpdateEventArgs $args
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $this->invalidate($args->getEntity());
    }

    /**
     * @param LifecycleEventArgs $args
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->invalidate($args->getEntity());
    }

    /**
     * @param LifecycleEventArgs $args
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->invalidate($args->getEntity());
    }

    /**
     * @param $entity
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function invalidate($entity): void
    {
        try {
            switch ($entity) {
                case $entity instanceof GlobalMessage :
                    $this->cache->invalidateTags(['message']);
                    break;

                case $entity instanceof Post :
                    $this->cache->invalidateTags(['posts']);
                    break;

                case $entity instanceof Tag :
                    $this->cache->invalidateTags(['tags']);
                    break;

                case $entity instanceof Category :
                    $this->cache->invalidateTags(['categories']);
                    break;
            }
        } catch (Exception | InvalidArgumentException $e) {
            $this->logger->error(
                sprintf("[%s] : %s ", __CLASS__, $e->getMessage()), $e->getTrace()
            );
        }
    }
}
