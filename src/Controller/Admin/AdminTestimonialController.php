<?php

namespace App\Controller\Admin;

use App\Entity\Testimonial;
use App\Form\TestimonialType;
use App\Repository\TestimonialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTestimonialController extends AbstractController
{
    private $testimonialRepo;

    public function __construct(TestimonialRepository $testimonialRepo)
    {
        $this->testimonialRepo = $testimonialRepo;
    }

    #[Route('/admin/testimonial', name: 'app_admin_testimonial')]
    public function index(): Response
    {
        return $this->render('admin/testimonial/index.html.twig', [
            'testimonials' => $this->testimonialRepo->findAll(),
        ]);
    }

    #[Route('/admin/testimonial/add', name: 'app_admin_testimonial_add')]
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $testimonial  = new Testimonial();
        $form = $this->createForm(TestimonialType::class, $testimonial);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $testimonial->setAuthor($this->getUser());
            $manager->persist($testimonial);
            $manager->flush();
            $this->addFlash('success', "Le témoignage <strong>{$testimonial->getTitle()}</strong> a bien été enregistrer.");
            return $this->redirectToRoute('app_admin_testimonial');
        }

        return $this->render('admin/testimonial/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/testimonial/{id}', name: 'app_admin_testimonial_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Testimonial $testimonial)
    {

        $form = $this->createForm(TestimonialType::class, $testimonial);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $testimonial->setAuthor($this->getUser());
            $manager->persist($testimonial);
            $manager->flush();
            $this->addFlash('success', "Le témoignage <strong>{$testimonial->getTitle()}</strong> a bien été enregistrer.");
            return $this->redirectToRoute('app_admin_testimonial');

        }

        return $this->render('admin/testimonial/new.html.twig', [
            'form' => $form->createView(),
            'testimonial' => $testimonial,
        ]);
    }
}
