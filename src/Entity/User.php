<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min="6")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="3", max="55")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_login_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $last_login_ip;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Blog", mappedBy="user")
     */
    private $blogs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Challenge", mappedBy="user")
     */
    private $challenges;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Solutions", mappedBy="user")
     */
    private $solutions;

    public function __construct()
    {
        $this->blogs = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->challenges = new ArrayCollection();
        $this->solutions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

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
        return (string) $this->email;
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
        return (string) $this->password;
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastLoginAt(): ?\DateTimeInterface
    {
        return $this->last_login_at;
    }

    public function setLastLoginAt(\DateTimeInterface $last_login_at): self
    {
        $this->last_login_at = $last_login_at;

        return $this;
    }

    public function getLastLoginIp(): ?string
    {
        return $this->last_login_ip;
    }

    public function setLastLoginIp(?string $last_login_ip): self
    {
        $this->last_login_ip = $last_login_ip;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

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

    public function addBlog(Blog $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->setUser($this);
        }

        return $this;
    }

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

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

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
     * @return Collection|Challenge[]
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function addChallenge(Challenge $challenge): self
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges[] = $challenge;
            $challenge->setUser($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenges->contains($challenge)) {
            $this->challenges->removeElement($challenge);
            // set the owning side to null (unless already changed)
            if ($challenge->getUser() === $this) {
                $challenge->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Solutions[]
     */
    public function getSolutions(): Collection
    {
        return $this->solutions;
    }

    public function addSolution(Solutions $solution): self
    {
        if (!$this->solutions->contains($solution)) {
            $this->solutions[] = $solution;
            $solution->setUser($this);
        }

        return $this;
    }

    public function removeSolution(Solutions $solution): self
    {
        if ($this->solutions->contains($solution)) {
            $this->solutions->removeElement($solution);
            // set the owning side to null (unless already changed)
            if ($solution->getUser() === $this) {
                $solution->setUser(null);
            }
        }

        return $this;
    }
}
