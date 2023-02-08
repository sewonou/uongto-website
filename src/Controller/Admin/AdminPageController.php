<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminPageController extends AbstractController
{
    #[Route('/admin/page', name: 'app_admin_page')]
    public function index(): Response
    {
        return $this->render('admin/page/index.html.twig', [

        ]);
    }

    #[Route('/admin/page/new', name: 'app_admin_page_add')]
    public function add(): Response
    {
        return $this->render('admin/page/index.html.twig', [

        ]);
    }

}
