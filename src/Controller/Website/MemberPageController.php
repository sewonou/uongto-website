<?php

namespace App\Controller\Website;

use App\Repository\PageRepository;
use App\Repository\PersonalityRepository;
use App\Repository\PostRepository;
use App\Repository\ThematicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberPageController extends AbstractController
{
    private $postRepo;
    private $thematicRepo;
    private $personalityRepo;
    private $pageRepo;

    public function __construct(PostRepository $postRepo, ThematicRepository $thematicRepo, PersonalityRepository $personalityRepo, PageRepository $pageRepo)
    {
        $this->postRepo = $postRepo;
        $this->thematicRepo = $thematicRepo;
        $this->personalityRepo = $personalityRepo;
        $this->pageRepo = $pageRepo;

    }

    #[Route('/members', name: 'app_member_page')]
    public function index(): Response
    {
        return $this->render('website/member/member.html.twig', [
            't_head' => true,
            'thematics' => $this->thematicRepo->findAll(),
        ]);
    }

    #[Route('/members/single', name: 'app_member_single_page')]
    public function member_single(): Response
    {
        return $this->render('website/member/member-single.html.twig', [
            't_head' => true,
        ]);
    }

    #[Route('/members/become-member', name: 'app_become_member_page')]
    public function become_member(): Response
    {
        return $this->render('website/member/become-member.html.twig', [
            't_head' => true,
        ]);
    }

}
