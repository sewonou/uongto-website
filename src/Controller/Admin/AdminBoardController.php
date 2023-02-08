<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBoardController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_board')]
    public function index(): Response
    {
        return $this->render('admin/board/index.html.twig', [

        ]);
    }

}
