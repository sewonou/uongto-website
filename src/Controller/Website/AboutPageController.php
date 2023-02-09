<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutPageController extends AbstractController
{
    #[Route('/about', name: 'app_about_page')]
    public function index(): Response
    {
        return $this->render('website/about/about-us.html.twig', [
            't_head' => true,
        ]);
    }

    #[Route('/about/single', name: 'app_about_single_page')]
    public function about_single(): Response
    {
        return $this->render('website/about/about-single.html.twig', [

        ]);
    }

    #[Route('/teams', name: 'app_team_page')]
    public function team(): Response
    {
        return $this->render('website/about/team.html.twig', [

        ]);
    }

    #[Route('/teams/single', name: 'app_team_single_page')]
    public function team_single(): Response
    {
        return $this->render('website/about/team-single.html.twig', [

        ]);
    }

    #[Route('/contact', name: 'app_contact_page')]
    public function contact_us(): Response
    {
        return $this->render('website/about/contact-us.html.twig', [
            't_head' => true
        ]);
    }

    #[Route('/historic', name: 'app_historic_page')]
    public function historic(): Response
    {
        return $this->render('website/about/historic.html.twig', [
            't_head'=>true
        ]);
    }

}
