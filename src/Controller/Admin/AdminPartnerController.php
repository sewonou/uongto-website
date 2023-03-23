<?php

namespace App\Controller\Admin;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPartnerController extends AbstractController
{
    private $partnerRepo;

    public function __construct(PartnerRepository $partnerRepo)
    {
        $this->partnerRepo = $partnerRepo;
    }

    #[Route('/admin/partner', name: 'app_admin_partner')]
    public function index(): Response
    {
        return $this->render('admin/partner/index.html.twig', [
            'partners' => $this->partnerRepo->findAll(),
        ]);
    }

    #[Route('/admin/partner/add', name: 'app_admin_partner_add')]
    public function create(EntityManagerInterface $manager,  Request $request): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $partner->setAuthor($this->getUser());
            $manager->persist($partner);
            $manager->flush();
            $this->addFlash('success', "Le partenaire <strong>{$partner->getName()} </strong> a bien été enregistrer");
            return $this->redirectToRoute('app_admin_partner');
        }
        return $this->render('admin/partner/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/partner/{id}', name: 'app_admin_partner_edit')]
    public function edit(EntityManagerInterface $manager,  Request $request, Partner $partner): Response
    {
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $partner->setAuthor($this->getUser());
            $manager->persist($partner);
            $manager->flush();
            $this->addFlash('success', "Le partenaire <strong>{$partner->getTitle()} </strong> a bien été enregistrer");
            return $this->redirectToRoute('app_admin_partner');
        }
        return $this->render('admin/partner/new.html.twig', [
            'form' => $form->createView(),
            'partner' => $partner
        ]);
    }
}
