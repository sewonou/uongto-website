<?php

namespace App\Controller\Admin;

use App\Entity\Personality;
use App\Form\PersonalityType;
use App\Repository\PersonalityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPersonalityController extends AbstractController
{
    private $personalityRepo;

    public function __construct(PersonalityRepository $personalityRepo)
    {
        $this->personalityRepo = $personalityRepo;
    }

    #[Route('/admin/personality', name: 'app_admin_personality')]
    public function index(): Response
    {
        return $this->render('admin/personality/index.html.twig', [
            'personalities' => $this->personalityRepo->findAll(),
        ]);
    }

    #[Route('/admin/personality/add', name: 'app_admin_personality_add')]
    public function addAction(EntityManagerInterface $manager, Request $request): Response
    {
        $personality = new Personality();
        $form = $this->createForm(PersonalityType::class, $personality);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $personality->setAuthor($this->getUser());
            $manager->persist($personality);
            $manager->flush();
            $this->addFlash('success', "La pernalité <strong>{$personality->getFullName()}</strong> a été enregister");
            return $this->redirectToRoute('app_admin_personality');
        }
        return $this->render('admin/personality/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/personality/{id}', name: 'app_admin_personality_edit')]
    public function editAction(EntityManagerInterface $manager, Request $request, Personality $personality): Response
    {

        $form = $this->createForm(PersonalityType::class, $personality);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $personality->setAuthor($this->getUser());
            $manager->persist($personality);
            $manager->flush();
            $this->addFlash('success', "La pernalité <strong>{$personality->getFullName()}</strong> a été enregister");
            return $this->redirectToRoute('app_admin_personality');
        }
        return $this->render('admin/personality/new.html.twig', [
            'form' => $form->createView(),
            'personality' => $personality
        ]);
    }
}
