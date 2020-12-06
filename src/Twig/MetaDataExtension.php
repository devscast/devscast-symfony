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

use stdClass;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class MetaDataExtension
 * @package App\Twig
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class MetaDataExtension extends AbstractExtension
{

    private ?stdClass $meta = null;

    private string $projectDir;

    /**
     * MetaDataExtension constructor.
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->projectDir = $kernel->getProjectDir();
    }

    /**
     * @return array
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('meta', [$this, 'getMetaData']),
        ];
    }

    /**
     * @return mixed
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getMetaData()
    {
        if (is_null($this->meta)) {
            $this->meta = json_decode(file_get_contents($this->projectDir . "/resources/meta.json"));
        }
        return $this->meta;
    }
}
