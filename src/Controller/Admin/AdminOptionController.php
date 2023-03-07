<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminOptionController extends AbstractController
{
    private $optionRepo;

    public function __construct(OptionRepository $repository)
    {
        $this->optionRepo = $repository;
    }


    #[Route('/admin/option', name: 'app_admin_option')]
    public function index(): Response
    {
        return $this->render('admin/option/index.html.twig', [
            'options' => $this->optionRepo->findAll(),
        ]);
    }

    #[Route('/admin/option/new', name: 'app_admin_option_add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $option->setAuthor($this->getUser());
            $this->addFlash('success', "L'option <strong>{$option->getTitle() }</strong> a bien été enregister");
            $manager->persist($option);
            $manager->flush();
            return  $this->redirectToRoute('app_admin_option');
        }
        return $this->render('admin/option/new.html.twig', [
            'form'=> $form->createView(),

        ]);
    }

    #[Route('/admin/option/{id}', name: 'app_admin_option_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Option $option): Response
    {

        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $option->setAuthor($this->getUser());
            $this->addFlash('success', "L'option <strong>{$option->getTitle() }</strong> a bien été enregister");
            $manager->persist($option);
            $manager->flush();
            return  $this->redirectToRoute('app_admin_option');
        }
        return $this->render('admin/option/new.html.twig', [
            'form'=> $form->createView(),
            'option' => $option,
        ]);
    }


}
