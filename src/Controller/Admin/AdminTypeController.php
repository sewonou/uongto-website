<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTypeController extends AbstractController
{
    #[Route('/admin/type', name: 'app_admin_type')]
    public function index(): Response
    {
        return $this->render('admin/type/index.html.twig', [

        ]);
    }

    #[Route('/admin/type/new', name: 'app_admin_type_add')]
    public function add(): Response
    {
        return $this->render('admin/type/index.html.twig', [

        ]);
    }


}
