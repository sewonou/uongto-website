<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_admin_user')]
    public function index(): Response
    {
        return $this->render('admin/user/index.html.twig', [

        ]);
    }

    #[Route('/admin/user', name: 'app_admin_user_add')]
    public function add(): Response
    {
        return $this->render('admin/user/index.html.twig', [

        ]);
    }


}
