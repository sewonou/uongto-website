<?php

namespace App\Controller\Website;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogPageController extends AbstractController
{
    private $postRepo;
    private $categoryRepo;
    private $pagination;

    public function __construct(PostRepository $repository, CategoryRepository $categoryRepo, PaginationService $pagination)
    {
        $this->postRepo = $repository;
        $this->categoryRepo = $categoryRepo;
        $this->pagination = $pagination;
    }

    #[Route('/news/{page<\d+>?1}', name: 'app_new_page')]
    public function index($page): Response
    {
        $this->pagination->setEntityClass(Post::class)
            ->setLimit(3)
            ->setPage($page);
        return $this->render('website/blog/blog.html.twig', [
            /*'posts' => $this->postRepo->findByActiveAndPublished(),*/
            'categories' => $this->categoryRepo->findIsPublishedAndIsActive(),
            'pagination' => $this->pagination,
        ]);
    }

    #[Route('/news/{slug}', name: 'app_new_single_page')]
    public function blog_single(Post $post, Request $request, EntityManagerInterface $manager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setIsPublished(true);
            $comment->setPost($post);
            $manager->persist($comment);
            $manager->flush();
            $success = 'Votre commentaire a bien été enregistrer';
            return $this->redirectToRoute('app_new_single_page', [
                'slug'=> $post->getSlug(),
                'success' => $success,
                'form' => $form->createView(),
                'post'=> $post,
                'categories' => $this->categoryRepo->findIsPublishedAndIsActive(),
            ]);

        }
        $this->postRepo->updateCount($post);
        return $this->render('website/blog/blog-single.html.twig', [
            'form' => $form->createView(),
            'post'=> $post,
            'categories' => $this->categoryRepo->findIsPublishedAndIsActive(),
        ]);
    }
}
