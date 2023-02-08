<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminParamController extends AbstractController
{
    #[Route('/admin/param', name: 'app_admin_param')]
    public function index(): Response
    {
        return $this->render('admin/param/index.html.twig', [

        ]);
    }

    #[Route('/admin/param/new', name: 'app_admin_param_add')]
    public function add(): Response
    {
        return $this->render('admin/param/index.html.twig', [

        ]);
    }

}
