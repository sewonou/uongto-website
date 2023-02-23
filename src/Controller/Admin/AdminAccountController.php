<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    #[Route('/admin/login', name: 'app_admin_login')]
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();

        return $this->render('admin/account/login.html.twig', [
            'last_username' => $utils->getLastUsername(),
            'hasError' => $error !== null,
        ]);
    }
    #[Route('/admin/logout', name: 'app_admin_logout')]
    public function logout()
    {

    }


}
