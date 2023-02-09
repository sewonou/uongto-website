<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsPageController extends AbstractController
{
    #[Route('/events', name: 'app_event_page')]
    public function index(): Response
    {
        return $this->render('website/blog/blog.html.twig', [

        ]);
    }

    #[Route('/events/single', name: 'app_event_single_page')]
    public function blog_single(): Response
    {
        return $this->render('website/blog/blog-single.html.twig', [

        ]);
    }
}
