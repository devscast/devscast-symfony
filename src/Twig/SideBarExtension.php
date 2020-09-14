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

use App\Repository\BlogRepository;
use Twig\Environment;
use Twig\TwigFunction;
use App\Repository\TagRepository;
use App\Repository\PostRepository;
use Twig\Extension\AbstractExtension;
use App\Repository\CategoryRepository;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

/**
 * Class SideBarExtension
 * @package App\Twig
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class SideBarExtension extends AbstractExtension
{

    private TagRepository $tagRepository;

    private CategoryRepository $categoryRepository;

    private PostRepository $postRepository;

    private TagAwareAdapterInterface $cache;

    private Environment $twig;

    private BlogRepository $blogRepository;

    /**
     * SideBarExtension constructor.
     * @param Environment $twig
     * @param TagAwareAdapterInterface $cache
     * @param TagRepository $tagRepository
     * @param CategoryRepository $categoryRepository
     * @param PostRepository $postRepository
     * @param BlogRepository $blogRepository
     */
    public function __construct(
        Environment $twig,
        TagAwareAdapterInterface $cache,
        TagRepository $tagRepository,
        CategoryRepository $categoryRepository,
        PostRepository $postRepository,
        BlogRepository $blogRepository
    ) {
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
        $this->cache = $cache;
        $this->twig = $twig;
        $this->blogRepository = $blogRepository;
    }

    /**
     * @return array
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('blog_sidebar', [$this, 'blogSideBar'], ['is_safe' => ['html']]),
            new TwigFunction('post_sidebar', [$this, 'postSideBar'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function blogSideBar(): string
    {
        return $this->cache->get('blogSideBar', function (ItemInterface $item) {
            $item->tag(['tags', 'categories', 'posts']);
            return $this->twig->render("app/blog/_sidebar.html.twig", [
                'tags' => $this->tagRepository->findAll(),
                'categories' => $this->categoryRepository->findAll(),
                'posts' => $this->blogRepository->findForSidebar()
            ]);
        });
    }

    /**
     * @author scotttresor <scotttresor@gmail.com>
     */
    public function postSideBar(): string
    {
        return  $this->cache->get('postSideBar', function (ItemInterface $item) {
            $item->tag(['posts']);
            return $this->twig->render('app/posts/_sidebar.html.twig', [
               'posts' =>$this->postRepository->findForSidebar()
            ]);
        });
    }
}
