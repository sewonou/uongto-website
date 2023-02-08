<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRegionController extends AbstractController
{
    #[Route('/admin/region', name: 'app_admin_region')]
    public function index(): Response
    {
        return $this->render('admin/region/index.html.twig', [

        ]);
    }

    #[Route('/admin/region/new', name: 'app_admin_region_add')]
    public function add(): Response
    {
        return $this->render('admin/region/index.html.twig', [

        ]);
    }

}
