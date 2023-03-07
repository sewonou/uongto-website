<?php

namespace App\Controller\Admin;

use App\Entity\Thematic;
use App\Form\ThematicType;
use App\Repository\ThematicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminThematicController extends AbstractController
{
    private $thematicRepo;

    public function __construct(ThematicRepository $thematicRepo)
    {
        $this->thematicRepo = $thematicRepo;
    }

    #[Route('/admin/thematic', name: 'app_admin_thematic')]
    public function index(): Response
    {
        return $this->render('admin/thematic/index.html.twig', [
            'thematics' => $this->thematicRepo->findAll(),
        ]);
    }

    #[Route('/admin/thematic/create', name: 'app_admin_thematic_add')]
    public function addAction(EntityManagerInterface $manager, Request $request)
    {
        $thematic = new Thematic();
        $form = $this->createForm(ThematicType::class, $thematic);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $thematic->setAuthor($this->getUser());
            $manager->persist($thematic);
            $manager->flush();
            $this->addFlash('success', "La Thematique <strong>{$thematic->getTitle()} </strong> a bien été enregistrer");
            return $this->redirectToRoute('app_admin_thematic');
        }
        return $this->render('admin/thematic/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/thematic/{id}', name: 'app_admin_thematic_edit')]
    public function editAction(EntityManagerInterface $manager, Request $request, Thematic $thematic)
    {

        $form = $this->createForm(ThematicType::class, $thematic);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $thematic->setAuthor($this->getUser());
            $manager->persist($thematic);
            $manager->flush();
            $this->addFlash('success', "La Thematique <strong>{$thematic->getTitle()} </strong> a bien été enregistrer");
            return $this->redirectToRoute('app_admin_thematic');
        }
        return $this->render('admin/thematic/new.html.twig', [
            'form' => $form->createView(),
            'thematic' => $thematic,
        ]);
    }


}
