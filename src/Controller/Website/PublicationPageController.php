<?php

namespace App\Controller\Website;

use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\OptionRepository;
use App\Repository\PostRepository;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;

class PublicationPageController extends AbstractController
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

    #[Route('/publications/{pageCategory}/{page<\d+>?1}', name: 'app_publication_page')]
    public function index($pageCategory, $page, RequestStack $request, DownloadHandler $downloadHandler): Response
    {
        $option = $this->optionRepo->findBy(['title' => $pageCategory], [], null, null);
        $categories = $this->categoryRepo->findByOption($option);
        $option = $this->optionRepo->findBy(['slug'=>$pageCategory], null,null, null);
        $latestPost = $this->postRepo->findLatestPost();
        $bestPost = $this->postRepo->findBestPost();
        //dd($option, $categories);
        $this->pagination->setEntityClass(Post::class)
            ->setLimit(5)
            ->setPage($page);
        return $this->render('website/publication/publication.html.twig', [
            'categories' => $categories,
            'pagination' => $this->pagination,
            'option' => $option[0],
            'latestPost' => $latestPost,
            'bestPost' => $bestPost,
            'downloader' => $downloadHandler,
        ]);
    }

    #[Route('/publications/single', name: 'app_publication_single_page')]
    public function blog_single(): Response
    {
        return $this->render('website/publication/publication-single.html.twig', [

        ]);
    }
}
