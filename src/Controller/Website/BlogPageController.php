<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogPageController extends AbstractController
{
    #[Route('/news', name: 'app_news_page')]
    public function index(): Response
    {
        return $this->render('website/blog/blog.html.twig', [

        ]);
    }

    #[Route('/news/single', name: 'app_news_single_page')]
    public function blog_single(): Response
    {
        return $this->render('website/blog/blog-single.html.twig', [

        ]);
    }
}
