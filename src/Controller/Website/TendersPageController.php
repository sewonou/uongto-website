<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TendersPageController extends AbstractController
{
    #[Route('/tenders', name: 'app_tenders_page')]
    public function index(): Response
    {
        return $this->render('website/blog/blog.html.twig', [

        ]);
    }

    #[Route('/tenders/single', name: 'app_tenders_single_page')]
    public function blog_single(): Response
    {
        return $this->render('website/blog/blog-single.html.twig', [

        ]);
    }
}
