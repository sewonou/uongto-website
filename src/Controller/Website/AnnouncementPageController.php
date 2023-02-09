<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncementPageController extends AbstractController
{
    #[Route('/announcement', name: 'app_announcement_page')]
    public function index(): Response
    {
        return $this->render('website/blog/blog.html.twig', [

        ]);
    }

    #[Route('/announcement/single', name: 'app_announcement_single_page')]
    public function blog_single(): Response
    {
        return $this->render('website/blog/blog-single.html.twig', [

        ]);
    }
}
