<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    #[Route('/admin/comment', name: 'app_admin_comment')]
    public function index(): Response
    {
        return $this->render('admin/comment/index.html.twig', [

        ]);
    }

    #[Route('/admin/comment/new', name: 'app_admin_comment_add')]
    public function add(): Response
    {
        return $this->render('admin/comment/new.html.twig', [

        ]);
    }

}
