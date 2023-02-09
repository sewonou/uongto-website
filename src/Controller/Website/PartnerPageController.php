<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerPageController extends AbstractController
{
    #[Route('/partners', name: 'app_partner_page')]
    public function index(): Response
    {
        return $this->render('website/partner/partner.html.twig', [

        ]);
    }

    #[Route('/partners', name: 'app_partner_page')]
    public function network(): Response
    {
        return $this->render('website/partner/our-network.html.twig', [

        ]);
    }

}
