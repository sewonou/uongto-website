<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberPageController extends AbstractController
{
    #[Route('/members', name: 'app_member_page')]
    public function index(): Response
    {
        return $this->render('website/partner/member.html.twig', [

        ]);
    }

    #[Route('/members/single', name: 'app_member_single_page')]
    public function member_single(): Response
    {
        return $this->render('website/partner/member.html.twig', [

        ]);
    }

    #[Route('/members/become-member', name: 'app_become_member_page')]
    public function become_member(): Response
    {
        return $this->render('website/partner/member.html.twig', [

        ]);
    }

}
