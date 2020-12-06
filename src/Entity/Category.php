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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Category
 * @Vich\Uploadable()
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @UniqueEntity("name")
 * @package App\Entity
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Length(min="3", max="255")
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="string", length=300, nullable=true)
     * @Assert\Length(min="3", max="300")
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $icon_url = null;

    /**
     * @Vich\UploadableField(mapping="categoriy_icon", fileNameProperty="icon_url")
     */
    private ?File $icon_file = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private ?DateTimeInterface $updated_at = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="category")
     * @OrderBy({"created_at" = "DESC"})
     */
    private Collection $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Blog", mappedBy="category")
     * @OrderBy({"created_at" = "DESC"})
     */
    private Collection $blogs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $slug = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $is_archived = false;

    /**
     * Category constructor.
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->blogs = new ArrayCollection();
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
     * @return string|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getIconUrl(): ?string
    {
        return $this->icon_url;
    }

    /**
     * @param string|null $icon_url
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setIconUrl(?string $icon_url): self
    {
        $this->icon_url = $icon_url;

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
     * @return DateTimeInterface|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @param DateTimeInterface|null $updated_at
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setUpdatedAt(?DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

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
            $post->setCategory($this);
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
            // set the owning side to null (unless already changed)
            if ($post->getCategory() === $this) {
                $post->setCategory(null);
            }
        }

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
            $blog->setCategory($this);
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
            // set the owning side to null (unless already changed)
            if ($blog->getCategory() === $this) {
                $blog->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return File|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getIconFile(): ?File
    {
        return $this->icon_file;
    }

    /**
     * @param File|null $icon_file
     * @return Category
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setIconFile(?File $icon_file): Category
    {
        $this->icon_file = $icon_file;
        if ($icon_file instanceof UploadedFile) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
        return $this;
    }

    /**
     * @return bool
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
