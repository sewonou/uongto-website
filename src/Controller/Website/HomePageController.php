<?php

namespace App\Controller\Website;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    private $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        $latestPosts = $this->postRepo->findLatestPost();
        return $this->render('website/home/index.html.twig', [
            'h-auto' => true,
            't-head' => true,
            'latestPosts' => $latestPosts,
        ]);
    }
}
