<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig;

use App\Entity\Tag;
use App\Entity\Post;
use Twig\TwigFunction;
use App\Entity\Category;
use App\Repository\TagRepository;
use App\Repository\PostRepository;
use Twig\Extension\AbstractExtension;
use App\Repository\CategoryRepository;

/**
 * Class PostSideBarExtension
 * @package App\Twig
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class PostSideBarExtension extends AbstractExtension
{

    /** @var TagRepository */
    private $tagRepository;

    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var PostRepository */
    private $postRepository;

    /**
     * PostSideBarExtension constructor.
     * @param TagRepository $tagRepository
     * @param CategoryRepository $categoryRepository
     * @param PostRepository $postRepository
     */
    public function __construct(
        TagRepository $tagRepository,
        CategoryRepository $categoryRepository,
        PostRepository $postRepository
    )
    {

        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @return array
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sidebar_tags', [$this, 'tags']),
            new TwigFunction('sidebar_categories', [$this, 'categories']),
            new TwigFunction('sidebar_posts', [$this, 'posts'])
        ];
    }

    /**
     * @return Tag[]|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function tags(): ?array
    {
        return $this->tagRepository->findAll();
    }

    /**
     * @return Category[]|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function categories(): ?array
    {
        return $this->categoryRepository->findAll();
    }

    /**
     * @return Post[]|null
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function posts(): ?array
    {
        return null;
    }
}
