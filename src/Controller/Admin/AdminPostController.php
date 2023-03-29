<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AbstractController
{
    private $postRepo;

    public function __construct(PostRepository $repository)
    {
        $this->postRepo =$repository;
    }


    #[Route('/admin/post', name: 'app_admin_post')]
    public function index(): Response
    {
        return $this->render('admin/post/index.html.twig', [
           'posts' => $this->postRepo->findAll(),
        ]);
    }

    #[Route('/admin/post/new', name: 'app_admin_post_add')]
    public function addAction(Request $request, EntityManagerInterface $manager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        //dd($post);

        if($form->isSubmitted()){
            $post->setAuthor($this->getUser());
            //dd($post, $request->server);
            $manager->persist($post);
            $manager->flush();
            $this->addFlash('success', "La page <strong>{$post->getTitle() }</strong> a bien été enregister");
            return $this->redirectToRoute('app_admin_post');
        }

        return $this->render('admin/post/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/post/{id}', name: 'app_admin_post_edit')]
    public function editAction(Request $request, EntityManagerInterface $manager, Post $post): Response
    {

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post->setAuthor($this->getUser());
            $manager->persist($post);
            $manager->flush();
            //$this->addFlash('success', "L'article <strong>{ $post->getTitle() }</strong> a bien été enregister");
            return $this->redirectToRoute('app_admin_post');
        }

        return $this->render('admin/post/new.html.twig', [
            'form' => $form->createView(),

        ]);
    }

}
