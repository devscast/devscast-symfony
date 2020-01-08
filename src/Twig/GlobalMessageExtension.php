<?php

namespace App\Twig;

use App\Entity\GlobalMessage;
use App\Repository\GlobalMessageRepository;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

/**
 * Class GlobalMessageExtension
 * @package App\Twig
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class GlobalMessageExtension extends AbstractExtension
{

    /** @var GlobalMessageRepository */
    private $messageRepository;

    /** @var Environment */
    private $twig;

    /** @var TagAwareAdapterInterface */
    private $cache;

    /**
     * GlobalMessageExtension constructor.
     * @param TagAwareAdapterInterface $cache
     * @param GlobalMessageRepository $messageRepository
     * @param Environment $twig
     */
    public function __construct(
        TagAwareAdapterInterface $cache,
        GlobalMessageRepository $messageRepository,
        Environment $twig)
    {
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
     * @param GlobalMessage $message
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
