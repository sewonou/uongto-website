<?php

namespace App\Controller\Website;

use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\OptionRepository;
use App\Repository\PostRepository;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsPageController extends AbstractController
{
    private $postRepo;
    private $categoryRepo;
    private $optionRepo;
    private $pagination;

    public function __construct(PostRepository $repository, CategoryRepository $categoryRepo, PaginationService $pagination, OptionRepository $optionRepo)
    {
        $this->postRepo = $repository;
        $this->categoryRepo = $categoryRepo;
        $this->pagination = $pagination;
        $this->optionRepo = $optionRepo;
    }
    #[Route('/events/{page<\d+>?1}', name: 'app_event_page')]
    public function index($page, RequestStack $request): Response
    {
        $l = ($request->getCurrentRequest()->attributes->get('page') == 1) ? 0 : strlen($request->getCurrentRequest()->attributes->get('page'))+1;
        $var = $request->getCurrentRequest()->getPathInfo();
        //dump($page);
        //dump($request->getCurrentRequest()->attributes->get('page') ,'variable  l', $l);
        $pageCategory = substr($var, 1, ($l==0) ? null : -$l);
        //dump($var ,$request->getCurrentRequest()->attributes->get('page') , $pageCategory, $l, $request->getCurrentRequest()->attributes->get('page'));
        //die();
        $option = $this->optionRepo->findBy(['title' => $pageCategory], [], null, null);
        $categories = $this->categoryRepo->findByOption($option);

        $this->pagination->setEntityClass(Post::class)
            ->setLimit(5)
            ->setPage($page);
        return $this->render('website/blog/blog.html.twig', [
            /*'posts' => $this->postRepo->findByActiveAndPublished(),*/
            'categories' => $categories,
            'pagination' => $this->pagination,
        ]);
    }

    #[Route('/events/{slug}', name: 'app_event_single_page')]
    public function blog_single(): Response
    {
        return $this->render('website/blog/blog-single.html.twig', [

        ]);
    }
}
