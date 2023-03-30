<?php

namespace App\Controller\Website;

use App\Entity\Member;
use App\Repository\MemberRepository;
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
    private $memberRepo;

    public function __construct(PostRepository $postRepo, ThematicRepository $thematicRepo, PersonalityRepository $personalityRepo, PageRepository $pageRepo, MemberRepository $memberRepo)
    {
        $this->postRepo = $postRepo;
        $this->thematicRepo = $thematicRepo;
        $this->personalityRepo = $personalityRepo;
        $this->pageRepo = $pageRepo;
        $this->memberRepo = $memberRepo;

    }

    #[Route('/members', name: 'app_member_page')]
    public function index(): Response
    {
        $members = $this->memberRepo->findBy(['isPublished'=>true], null, null, null);

        return $this->render('website/member/member.html.twig', [
            't_head' => true,
            'thematics' => $this->thematicRepo->findAll(),
            'members' => $members,
        ]);
    }

    #[Route('/members/{slug}', name: 'app_member_single_page')]
    public function member_single(Member $member): Response
    {
        return $this->render('website/member/member-single.html.twig', [
            't_head' => true,
            'member' => $member,
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
