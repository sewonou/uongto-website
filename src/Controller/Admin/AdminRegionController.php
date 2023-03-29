<?php

namespace App\Controller\Admin;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRegionController extends AbstractController
{
    private $regionRepo;

    public function __construct(RegionRepository $regionRepo)
    {
        $this->regionRepo = $regionRepo;
    }

    #[Route('/admin/region', name: 'app_admin_region')]
    public function index(): Response
    {
        return $this->render('admin/region/index.html.twig', [
            'regions' => $this->regionRepo->findAll(),
        ]);
    }

    #[Route('/admin/region/new', name: 'app_admin_region_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $region = new Region();
        $form = $this->createForm(RegionType::class,  $region);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $region->setAuthor($this->getUser());
            $manager->persist($region);
            $manager->flush();
            $this->addFlash('success', "la région <strong>{$region->getTitle()}</strong> a bien été enregitrer" );
            return $this->redirectToRoute('app_admin_region');
        }


        return $this->render('admin/region/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/region/{id}', name: 'app_admin_region_edit')]
    public function modify(Request $request, EntityManagerInterface $manager, Region $region): Response
    {

        $form = $this->createForm(RegionType::class,  $region);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $region->setAuthor($this->getUser());
            $manager->persist($region);
            $manager->flush();
            $this->addFlash('success', "la région <strong>{$region->getTitle()}</strong> a bien été enregitrer" );
            return $this->redirectToRoute('app_admin_region');
        }


        return $this->render('admin/region/new.html.twig', [
            'form' => $form->createView(),
            'region' =>$region,
        ]);
    }

}
