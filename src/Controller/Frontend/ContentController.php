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

namespace App\Controller\Frontend;

use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContentController
 * @package App\Controller
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ContentController extends AbstractController
{
    /**
     * @Route(
     *     path="/categories/{slug}",
     *     name="app_category_show",
     *     methods={"GET"},
     *     requirements={"slug":"[a-z0-9-]+"}
     * )
     * @param Category $category
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function category(Category $category): Response
    {
        return $this->render('@frontend/content/category.html.twig', [
            'category' => $category,
            'posts' => $category->getPosts(),
            'data_type' => 'post'
        ]);
    }

    /**
     * @Route(
     *     path="/tags/{name}",
     *     name="app_tag_show",
     *     methods={"GET"},
     *     requirements={"slug":"[a-z0-9-]+"}
     * )
     * @param Tag $tag
     * @return Response
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function tag(Tag $tag): Response
    {
        return $this->render('@frontend/content/tag.html.twig', [
            'tag' => $tag,
            'posts' => $tag->getPosts(),
            'data_type' => 'post'
        ]);
    }
}
