<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMemberController extends AbstractController
{
    #[Route('/admin/member', name: 'app_admin_member')]
    public function index(): Response
    {
        return $this->render('admin/member/index.html.twig', [

        ]);
    }

    #[Route('/admin/member/neww', name: 'app_admin_member_add')]
    public function add(): Response
    {
        return $this->render('admin/member/index.html.twig', [

        ]);
    }

}
