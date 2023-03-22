<?php

namespace App\Controller\Admin;

use App\Entity\Goal;
use App\Form\GoalType;
use App\Repository\GoalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminGoalController extends AbstractController
{
    private $goalRepo;

    public function __construct(GoalRepository $goalRepo)
    {
        $this->goalRepo = $goalRepo;
    }


    #[Route('/admin/goal', name: 'app_admin_goal')]
    public function index(): Response
    {
        return $this->render('admin/goal/index.html.twig', [
            'goals' => $this->goalRepo->findAll(),
        ]);
    }

    #[Route('/admin/goal/add', name: 'app_admin_goal_add')]
    public function create(Request $request, EntityManagerInterface $manager ): Response
    {
        $goal = new Goal();
        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $goal->setAuthor($this->getUser());
            $manager->persist($goal);
            $manager->flush();

            $this->addFlash('success', "L'objectif <strong>{$goal->getTitle() }</strong> a bien été enregister");
            return $this->redirectToRoute('app_admin_goal');
        }

        return $this->render('admin/goal/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/goal/{id}', name: 'app_admin_goal_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Goal $goal): Response
    {
        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $goal->setAuthor($this->getUser());
            $manager->persist($goal);
            $manager->flush();

            $this->addFlash('success', "L'objectif <strong>{$goal->getTitle() }</strong> a bien été enregister");
            return $this->redirectToRoute('app_admin_goal');
        }

        return $this->render('admin/goal/new.html.twig', [
            'form' => $form->createView(),
            'goal' => $goal
        ]);
    }
}
