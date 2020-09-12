<?php 

namespace App\Twig;

use App\Repository\PostRepository;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TutoSideBarExtension extends AbstractExtension
{
    private Environment $twig;

    private TagAwareAdapterInterface $cache;

    private PostRepository $postRepository;

    public function __construct(
        Environment $twig,
        TagAwareAdapterInterface $cache,
        PostRepository  $postRepository
    )
    {
        $this->twig = $twig;
        $this->cache =  $cache;
        $this->postRepository = $postRepository;
    }

    /**
     * @return array
     * @author scotttresor <scotttresor@gmail.com>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sidebar', [$this, 'sidebar'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @return string
     * @throws  LoaderError
     * @throws RuntimeError
     * @throws SynthaxError
     * @author scotttresor <scotttresor@gmail.com>
     */
    public function sidebar(): string
    {
        return $this->cache->get('sidebar', function(ItemInterface $item){
            $item->tag('posts');
            return $this->renderSiderbar();
        });
    }


    /**
     * @return string
     * @throws  LoaderError
     * @throws RuntimeError
     * @throws SynthaxError
     * @author scotttresor <scotttresor@gmail.com>
     */
    public function renderSiderbar():string
    {
        return $this->twig->render('app/blog/_sidebar.html.twig', [
            'posts' => $this->postRepository->findForSidebar()
        ]);
    }
}