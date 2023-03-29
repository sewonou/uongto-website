<?php

namespace App\Controller\Website;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\OptionRepository;
use App\Repository\PostRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\length;

class BlogPageController extends AbstractController
{
    private $postRepo;
    private $categoryRepo;
    private $optionRepo;
    private $pagination;

    public function __construct(PostRepository $repository, CategoryRepository $categoryRepo, PaginationService $pagination, OptionRepository $optionRepo)
    {
        $this->postRepo = $repository;
        $this->categoryRepo = $categoryRepo;
        $this->pagination = $pagination;
        $this->optionRepo = $optionRepo;
    }

    #[Route('/blog/{pageCategory}/{page<\d+>?1}', name: 'app_blog_page')]
    public function index($pageCategory, $page, RequestStack $request): Response
    {

        //$l = ($request->getCurrentRequest()->attributes->get('page') == 1) ? 0 : strlen($request->getCurrentRequest()->attributes->get('page'))+1;
        //$var = $request->getCurrentRequest()->getPathInfo();
        //$pageCategory = $pageCategory;substr($var, 1, ($l==0) ? null : -$l);
        $option = $this->optionRepo->findBy(['title' => $pageCategory], [], null, null);
        $categories = $this->categoryRepo->findByOption($option);
        $option = $this->optionRepo->findBy(['slug'=>$pageCategory], null,null, null);
        $latestPost = $this->postRepo->findLatestPost();
        $bestPost = $this->postRepo->findBestPost();
        $this->pagination->setEntityClass(Post::class)
            ->setLimit(5)
            ->setPage($page);
        return $this->render('website/blog/blog.html.twig', [
            /*'posts' => $this->postRepo->findByActiveAndPublished(),*/
            'categories' => $categories,
            'pagination' => $this->pagination,
            'option' => $option[0],
            'latestPost' => $latestPost,
            'bestPost' => $bestPost,
        ]);
    }

    #[Route('/blog/{pageCategory}/{slug}', name: 'app_blog_single_page')]
    public function blog_single($pageCategory,Post $post, Request $request, EntityManagerInterface $manager, RequestStack $stack): Response
    {

        $option = $this->optionRepo->findBy(['title' => $pageCategory], [], null, null);
        $categories = $this->categoryRepo->findByOption($option);
        $option = $this->optionRepo->findBy(['slug'=>$pageCategory], null,null, null);
        $latestPost = $this->postRepo->findLatestPost();
        $bestPost = $this->postRepo->findBestPost();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setIsPublished(true);
            $comment->setPost($post);
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('app_blog_single_page', ['pageCategory'=>$pageCategory, 'slug'=>$post->getSlug()]);

        }
        $this->postRepo->updateCount($post);
        return $this->render('website/blog/blog-single.html.twig', [
            'form' => $form->createView(),
            'post'=> $post,
            'categories' => $categories,
            'option' => $option[0],
            'latestPost' => $latestPost,
            'bestPost' => $bestPost,
        ]);
    }


    #[Route('/category/{pageCategory}/{slug}', name: 'app_category_single_page')]
    public function blog_category_single(Category $blogCategory,$pageCategory,Post $post, Request $request, EntityManagerInterface $manager, RequestStack $stack): Response
    {
        //$l = strlen($stack->getCurrentRequest()->attributes->get('slug'))+1;
        //$var = $stack->getCurrentRequest()->getPathInfo();
        //$pageCategory = substr($var, 1, -$l);

        dd($pageCategory);
        $option = $this->optionRepo->findBy(['title' => $pageCategory], [], null, null);
        $categories = $this->categoryRepo->findByOption($option);
        $option = $this->optionRepo->findBy(['slug'=>$pageCategory], null,null, null);
        $latestPost = $this->postRepo->findLatestPost();
        $bestPost = $this->postRepo->findBestPost();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setIsPublished(true);
            $comment->setPost($post);
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('app_blog_single_page', ['pageCategory'=>$pageCategory, 'slug'=>$post->getSlug()]);

        }
        $this->postRepo->updateCount($post);
        return $this->render('website/blog/blog-single.html.twig', [
            'form' => $form->createView(),
            'post'=> $post,
            'categories' => $categories,
            'option' => $option[0],
            'latestPost' => $latestPost,
            'bestPost' => $bestPost,
        ]);
    }
}
