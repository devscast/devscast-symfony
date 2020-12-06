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

namespace App\Twig;

use App\Entity\GlobalMessage;
use App\Repository\GlobalMessageRepository;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class GlobalMessageExtension
 * @package App\Twig
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class GlobalMessageExtension extends AbstractExtension
{

    private GlobalMessageRepository $messageRepository;
    private Environment $twig;
    private TagAwareAdapterInterface $cache;

    /**
     * GlobalMessageExtension constructor.
     * @param TagAwareAdapterInterface $cache
     * @param GlobalMessageRepository $messageRepository
     * @param Environment $twig
     */
    public function __construct(
        TagAwareAdapterInterface $cache,
        GlobalMessageRepository $messageRepository,
        Environment $twig
    ) {
        $this->messageRepository = $messageRepository;
        $this->twig = $twig;
        $this->cache = $cache;
    }

    /**
     * @return array
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('global_message', [$this, 'message'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @return mixed
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws \Psr\Cache\CacheException
     * @throws \Psr\Cache\InvalidArgumentException
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function message()
    {
        return $this->cache->get("message", function (ItemInterface $item) {
            $item->tag(['message']);
            $message = $this->messageRepository->findLastMessage();
            return $this->renderMessage($message);
        });
    }


    /**
     * @param GlobalMessage|null $message
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function renderMessage(?GlobalMessage $message): string
    {
        if (!is_null($message)) {
            return $this->twig->render("app/includes/_message.html.twig", compact("message"));
        }
        return "";
    }
}
