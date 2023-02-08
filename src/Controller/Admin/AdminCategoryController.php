<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'app_admin_category')]
    public function index(): Response
    {
        return $this->render('admin/category/index.html.twig', [

        ]);
    }

    #[Route('/admin/category/new', name: 'app_admin_category_add')]
    public function add(): Response
    {
        return $this->render('admin/category/new.html.twig', [

        ]);
    }

}
