<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationPageController extends AbstractController
{
    #[Route('/publications', name: 'app_publication_page')]
    public function index(): Response
    {
        return $this->render('website/publication/publication.html.twig', [

        ]);
    }

    #[Route('/publications/single', name: 'app_publication_single_page')]
    public function blog_single(): Response
    {
        return $this->render('website/publication/publication-single.html.twig', [

        ]);
    }
}
