<?php

namespace App\Controller\Website;

use App\Entity\Post;
use App\Repository\GoalRepository;
use App\Repository\PageRepository;
use App\Repository\PersonalityRepository;
use App\Repository\PostRepository;
use App\Repository\ThematicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutPageController extends AbstractController
{
    private $postRepo;
    private $thematicRepo;
    private $personalityRepo;
    private $pageRepo;
    private $goalRepo;

    public function __construct(PostRepository $postRepo, ThematicRepository $thematicRepo, PersonalityRepository $personalityRepo, PageRepository $pageRepo, GoalRepository $goalRepo)
    {
        $this->postRepo = $postRepo;
        $this->thematicRepo = $thematicRepo;
        $this->personalityRepo = $personalityRepo;
        $this->pageRepo = $pageRepo;
        $this->goalRepo = $goalRepo;

    }

    #[Route('/about', name: 'app_about_page')]
    public function index(): Response
    {
        $page = $this->pageRepo->findBy(['codeName'=>'about'], null, null, null);
        $page = $page[0];
        $personalities = $this->personalityRepo->findBy(['page'=>$page, 'isPublished' =>true], null, null, null);
        $goals = $this->goalRepo->findBy(['isPublished'=>true], null, null, null);
        //$posts = $this->postRepo->findBy(['page'=>$page, 'isPublished'=>true, 'isActive'=>true], null, null, null);
        //dd($page, $personalities, $posts);


        return $this->render('website/about/about-us.html.twig', [
            't_head' => true,
            'thematics' => $this->thematicRepo->findAll(),
            'personalities' => $personalities,
            'goals' => $goals,
        ]);
    }

    #[Route('/about/slug', name: 'app_about_single_page')]
    public function about_single(Post $post): Response
    {
        return $this->render('website/about/about-single.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/teams', name: 'app_team_page')]
    public function team(): Response
    {
        return $this->render('website/about/team.html.twig', [
            't_head' => true,
        ]);
    }

    #[Route('/teams/single', name: 'app_team_single_page')]
    public function team_single(): Response
    {
        return $this->render('website/about/team-single.html.twig', [

        ]);
    }

    #[Route('/contact', name: 'app_contact_page')]
    public function contact_us(): Response
    {
        return $this->render('website/about/contact-us.html.twig', [
            't_head' => true
        ]);
    }

    #[Route('/historic', name: 'app_historic_page')]
    public function historic(): Response
    {
        return $this->render('website/about/historic.html.twig', [
            't_head'=>true
        ]);
    }

}
