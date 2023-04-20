<?php

namespace App\Controller\Website;

use App\Repository\CategoryRepository;
use App\Repository\OptionRepository;
use App\Repository\PageRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PleadingPageController extends AbstractController
{
    private $postRepo;
    private $categoryRepo;
    private $optionRepo;
    private $pageRepo;

    public function __construct(PostRepository $repository, CategoryRepository $categoryRepo, OptionRepository $optionRepo, PageRepository $pageRepo)
    {
        $this->postRepo = $repository;
        $this->categoryRepo = $categoryRepo;
        $this->pageRepo = $pageRepo;
        $this->optionRepo = $optionRepo;
    }

    #[Route('/{pageCategory}/', name: 'app_pleading_page')]
    public function index($pageCategory): Response
    {
        $option = $this->optionRepo->findBy(['title' => $pageCategory], [], null, null);
        $page = $this->pageRepo->findBy(['codeName'=> $pageCategory], [], null, null);
        $posts = $this->postRepo->findBy(['page'=> $page[0]], [], null, null);
        return $this->render('website/pleading/index.html.twig', [
            'option' => $option[0],
            'posts' => $posts
        ]);
    }
}
