<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    private $categoryRepo;

    public function __construct(CategoryRepository $repo)
    {
        $this->categoryRepo = $repo;
    }


    #[Route('/admin/category', name: 'app_admin_category')]
    public function index(): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $this->categoryRepo->findAll(),
        ]);
    }

    #[Route('/admin/category/new', name: 'app_admin_category_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $category->setAuthor($this->getUser());
            $this->addFlash('success', "La Categorie <strong>{$category->getTitle() }</strong> a bien été enregister");
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('app_admin_category');
        }

        return $this->render('admin/category/new.html.twig', [
            'form' => $form->createView(),

        ]);
    }

    #[Route('/admin/category/{id}', name: 'app_admin_category_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $category->setAuthor($this->getUser());
            $this->addFlash('success', "La Categorie <strong>{$category->getTitle() }</strong> a bien été enregister");
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('app_admin_category');
        }

        return $this->render('admin/category/new.html.twig', [
            'form' => $form->createView(),
            'category' => $category,
        ]);
    }

}
