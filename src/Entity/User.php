<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email()
     */
    private ?string $email = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     */
    private ?string $roles = 'ROLE_USER';

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min="6", max="4096")
     */
    private ?string $password = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="3", max="55")
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $last_login_at = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $last_login_ip = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $updated_at = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $avatar = null;

    /**
     * @Vich\UploadableField(mapping="user_avatar", fileNameProperty="avatar")
     */
    private ?File $avatar_file = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Blog", mappedBy="user")
     */
    private Collection $blogs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user")
     */
    private Collection $posts;

    /**
     * @ORM\Column(type="boolean")
     */
    private int $is_archived = 0;

    /**
     * User constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->blogs = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->created_at = new \DateTime();
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles = explode('|', $roles);
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    /**
     * @return string
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getRolesAsString(): string
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setRoles(array $roles): self
    {
        $this->roles = implode('|', $roles);
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    /**
     * @param string $password
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
     * @return DateTimeInterface|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getLastLoginAt(): ?DateTimeInterface
    {
        return $this->last_login_at;
    }

    /**
     * @param DateTimeInterface $last_login_at
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setLastLoginAt(DateTimeInterface $last_login_at): self
    {
        $this->last_login_at = $last_login_at;

        return $this;
    }

    /**
     * @return string|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getLastLoginIp(): ?string
    {
        return $this->last_login_ip;
    }

    /**
     * @param string|null $last_login_ip
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setLastLoginIp(?string $last_login_ip): self
    {
        $this->last_login_ip = $last_login_ip;

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
     * @param DateTimeInterface $updated_at
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setUpdatedAt(DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return string|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     * @return $this
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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
            $blog->setUser($this);
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
            if ($blog->getUser() === $this) {
                $blog->setUser(null);
            }
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
            $post->setUser($this);
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
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return File|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getAvatarFile(): ?File
    {
        return $this->avatar_file;
    }

    /**
     * @param File|null $avatar_file
     * @return User
     * @throws \Exception
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function setAvatarFile(?File $avatar_file): User
    {
        $this->avatar_file = $avatar_file;
        if ($avatar_file instanceof UploadedFile) {
            $this->setCreatedAt(new DateTime());
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
