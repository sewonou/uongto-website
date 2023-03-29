<?php

namespace App\Controller\Admin;

use App\Entity\Historic;
use App\Form\HistoricType;
use App\Repository\HistoricRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHistoricController extends AbstractController
{
    private $historicRepo;

    public function __construct(HistoricRepository $historicRepo)
    {
        $this->historicRepo = $historicRepo;
    }

    #[Route('/admin/historic', name: 'app_admin_historic')]
    public function index(): Response
    {
        return $this->render('admin/historic/index.html.twig', [
            'histories' => $this->historicRepo->findAll(),
        ]);
    }

    #[Route('/admin/historic/new', name: 'app_admin_historic_add')]
    public function create(EntityManagerInterface $manager,  Request $request)
    {
        $historic = new Historic();
        $form = $this->createForm(HistoricType::class, $historic);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $historic->setAuthor($this->getUser());
            $manager->persist($historic);
            $manager->flush();
            $this->addFlash('success', "L'historique <strong>{$historic->getYear()}</strong> a bien été enregistrer");
            return $this->redirectToRoute('app_admin_historic');
        }
        return $this->render('admin/historic/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/historic/{id}', name: 'app_admin_historic_edit')]
    public function edit(EntityManagerInterface $manager,  Request $request, Historic $historic)
    {

        $form = $this->createForm(HistoricType::class, $historic);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $historic->setAuthor($this->getUser());
            $manager->persist($historic);
            $manager->flush();
            $this->addFlash('success', "L'historique <strong>{$historic->getYear()}</strong> a bien été enregistrer");
            return $this->redirectToRoute('app_admin_historic');
        }
        return $this->render('admin/historic/new.html.twig', [
            'form' => $form->createView(),
            'historic' => $historic,
        ]);
    }
}
