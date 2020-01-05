<?php

namespace App\Twig;

use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class MetaDataExtension
 * @package App\Twig
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class MetaDataExtension extends AbstractExtension
{

    private $meta;

    /** @var string */
    private $projectDir;

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
     * @todo use absolute path for meta.json
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
