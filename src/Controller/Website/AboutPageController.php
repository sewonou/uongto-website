<?php

namespace App\Controller\Website;

use App\Entity\Post;
use App\Repository\GoalRepository;
use App\Repository\HistoricRepository;
use App\Repository\PageRepository;
use App\Repository\PartnerRepository;
use App\Repository\PersonalityRepository;
use App\Repository\PostRepository;
use App\Repository\TestimonialRepository;
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
    private $testimonialRepo;
    private $partnerRepo;
    private $historicRepo;

    public function __construct(PostRepository $postRepo, ThematicRepository $thematicRepo, PersonalityRepository $personalityRepo, PageRepository $pageRepo, GoalRepository $goalRepo, TestimonialRepository $testimonialRepo, PartnerRepository $partnerRepo, HistoricRepository $historicRepo)
    {
        $this->postRepo = $postRepo;
        $this->thematicRepo = $thematicRepo;
        $this->personalityRepo = $personalityRepo;
        $this->pageRepo = $pageRepo;
        $this->goalRepo = $goalRepo;
        $this->testimonialRepo = $testimonialRepo;
        $this->partnerRepo = $partnerRepo;
        $this->historicRepo = $historicRepo;

    }

    #[Route('/about', name: 'app_about_page')]
    public function index(): Response
    {
        $page = $this->pageRepo->findBy(['codeName'=>'about'], null, null, null);
        $page = $page[0];
        $personalities = $this->personalityRepo->findBy(['page'=>$page, 'isPublished' =>true], null, null, null);
        $goals = $this->goalRepo->findBy(['isPublished'=>true], null, null, null);
        $partners = $this->partnerRepo->findBy(['isPublished' => true], null, null, null);
        $testimonials = $this->testimonialRepo->findBy(['isPublished' => true, 'page'=>$page], null, null, null);
        //$posts = $this->postRepo->findBy(['page'=>$page, 'isPublished'=>true, 'isActive'=>true], null, null, null);
        //dd($page, $personalities, $posts);
        //$this->partnerRepo->findBy(['isPublished' => true, 'page'=> $page], null, null, null);

        return $this->render('website/about/about-us.html.twig', [
            't_head' => true,
            'thematics' => $this->thematicRepo->findAll(),
            'personalities' => $personalities,
            'goals' => $goals,
            'partners' => $partners,
            'testimonials' => $testimonials,
        ]);
    }

    #[Route('/about/slug', name: 'app_about_single_page')]
    public function about_single(/*Post $post*/): Response
    {
        return $this->render('website/about/about-single.html.twig', [
            /*'post' => $post,*/
        ]);
    }

    #[Route('/teams', name: 'app_team_page')]
    public function team(): Response
    {
        $page = $this->pageRepo->findBy(['codeName'=>'teams'], null, null, null);
        $page = $page[0];
        //dump($page);
        $personalities = $this->personalityRepo->findBy(['page'=>$page, 'isPublished' =>true], null, null, null);
        return $this->render('website/about/team.html.twig', [
            't_head' => true,
            'personalities' => $personalities,
            'thematics' => $this->thematicRepo->findAll(),

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

    #[Route('/about/historic', name: 'app_historic_page')]
    public function historic(): Response
    {
        $histories = $this->historicRepo->findBy(['isPublished' => true], null, null, null);
        //dump($histories);
        return $this->render('website/about/historic.html.twig', [
            't_head'=>true,
            'histories' => $histories,
        ]);
    }

}
