<?php

namespace App\Controller\Website;

use App\Repository\PostRepository;
use App\Repository\ThematicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    private $postRepo;
    private $thematicRepo;

    public function __construct(PostRepository $postRepo, ThematicRepository $thematicRepo)
    {
        $this->postRepo = $postRepo;
        $this->thematicRepo = $thematicRepo;
    }

    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        $latestPosts = $this->postRepo->findisOnFirstPost();
        $posts = $this->postRepo->findBy([], ['id'=>'DESC'], 6);
        return $this->render('website/home/index.html.twig', [
            'h-auto' => true,
            't-head' => true,
            'latestPosts' => $latestPosts,
            'thematics' => $this->thematicRepo->findAll(),
            'posts' => $posts
        ]);
    }
}
