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

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GlobalMessage
 * @ORM\Entity(repositoryClass="App\Repository\GlobalMessageRepository")
 * @package App\Entity
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class GlobalMessage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\NotBlank()
     */
    private ?string $content = null;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\Choice({"danger", "info", "warning", "success"})
     */
    private string $type = 'info';

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $state = false;


    /**
     * GlobalMessage constructor.
     */
    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
    }

    /**
     * @return int|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param DateTimeInterface $created_at
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return bool|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getState(): ?bool
    {
        return $this->state;
    }

    /**
     * @param bool $state
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setState(bool $state): self
    {
        $this->state = $state;

        return $this;
    }
}
