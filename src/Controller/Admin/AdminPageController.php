<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Form\PageType;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminPageController extends AbstractController
{
    private $pageRepo;

    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }

    #[Route('/admin/page', name: 'app_admin_page')]
    public function index(): Response
    {
        return $this->render('admin/page/index.html.twig', [
            'pages' => $this->pageRepo->findAll()
        ]);
    }

    #[Route('/admin/page/new', name: 'app_admin_page_add')]

    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $page = new Page();
        $form =  $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($form->isSubmitted() && $form->isValid()){
            $page->setUser($user);
            $this->addFlash('success', "La page <strong>{$page->getTitle() }</strong> a bien été enregister");
            $manager->persist($page);
            $manager->flush();
            return $this->redirectToRoute('app_admin_page');
        }
        return $this->render('admin/page/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/page/{id}', name: 'app_admin_page_edit')]

    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, EntityManagerInterface $manager, Page $page): Response
    {

        $form =  $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        $user = $this->getUser();
        if($form->isSubmitted() && $form->isValid()){
            $page->setUser($user);
            $this->addFlash('success', "La page <strong>{$page->getTitle() }</strong> a bien été enregister");
            $manager->persist($page);
            $manager->flush();
            return $this->redirectToRoute('app_admin_page');
        }
        return $this->render('admin/page/new.html.twig', [
            'form' => $form->createView(),
            'page' => $page
        ]);
    }
}
