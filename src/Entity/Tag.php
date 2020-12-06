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

use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @UniqueEntity("name")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="3",max="50")
     */
    private ?string $name = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Blog", mappedBy="tags")
     * @OrderBy({"created_at" = "DESC"})
     */
    private Collection $blogs;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Post", mappedBy="tags")
     * @OrderBy({"created_at" = "DESC"})
     */
    private Collection $posts;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $is_archived = false;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->blogs = new ArrayCollection();
        $this->posts = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Blog[]
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    /**
     * @param Blog $blog
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function addBlog(Blog $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->addTag($this);
        }

        return $this;
    }

    /**
     * @param Blog $blog
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function removeBlog(Blog $blog): self
    {
        if ($this->blogs->contains($blog)) {
            $this->blogs->removeElement($blog);
            $blog->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @param Post $post
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->addTag($this);
        }

        return $this;
    }

    /**
     * @param Post $post
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            $post->removeTag($this);
        }

        return $this;
    }

    /**
     * @return bool|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getIsArchived(): ?bool
    {
        return $this->is_archived;
    }

    /**
     * @param bool $is_archived
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setIsArchived(bool $is_archived): self
    {
        $this->is_archived = $is_archived;

        return $this;
    }
}
