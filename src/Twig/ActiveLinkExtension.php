<?php

declare(strict_types=1);

namespace App\Twig;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class ActiveLinkExtension
 * @package App\Twig
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ActiveLinkExtension extends AbstractExtension
{
    private ?Request $request;
    private LoggerInterface $logger;

    /**
     * ActiveLinkExtension constructor.
     * @param RequestStack $request
     * @param LoggerInterface $logger
     */
    public function __construct(RequestStack $request, LoggerInterface $logger)
    {
        $this->request = $request->getCurrentRequest();
        $this->logger = $logger;
    }

    /**
     * @return array
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('active_link', [$this, 'activeLink']),
            new TwigFunction('active_stats', [$this, 'activeStats'], ['is_safe' => ['html']]),
            new TwigFunction('active_status', [$this, 'activeStatus'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param string $route
     * @param string $class
     * @return string
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function activeLink(string $route, string $class = 'active'): string
    {
        try {
            $currentRoute = $this->request->get('_route');
            if ($route === $currentRoute) {
                return $class;
            }

            $a = explode('_', $route);
            $b = explode('_', $currentRoute);
            return ($a[1] === $b[1]) ? $class : '';
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            return '';
        }
    }

    /**
     * @param string $format
     * @param array $stats
     * @param string $type
     * @return string
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function activeStats(string $format, array $stats, string $type = 'COUNT'): string
    {
        $formattedStats = array_map(function ($stat) use ($type) {
            $positive = ($type === 'RATIO') ? $stat > 50.0 : $stat > 0;
            $stat = ($type === 'RATIO') ? "{$stat} %" : $stat;

            return $positive
                ? "<span class='tx-success'>{$stat}</span>"
                : "<span class='tx-danger'>{$stat}</span>";
        }, $stats);

        return vsprintf($format, $formattedStats);
    }

    /**
     * @param $active
     * @return string
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function activeStatus($active): string
    {
        $active = boolval($active);
        return $active ?
            '<i class="text-success" data-feather="check"></i>' :
            '<i class="text-danger" data-feather="x"></i>';
    }
}
