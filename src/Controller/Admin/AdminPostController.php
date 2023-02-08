<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AbstractController
{
    #[Route('/admin/post', name: 'app_admin_post')]
    public function index(): Response
    {
        return $this->render('admin/post/index.html.twig', [

        ]);
    }

    #[Route('/admin/post/new', name: 'app_admin_post_add')]
    public function add(): Response
    {
        return $this->render('admin/post/new.html.twig', [

        ]);
    }

}
