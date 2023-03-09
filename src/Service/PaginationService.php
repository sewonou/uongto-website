<?php

namespace App\Service;

use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Classe de pagination qui extrait toute notion de calcul et de récupération de données de nos controllers
 *NB: Cette pagination est valable uniquement sur postPage
 * Elle nécessite après instanciation qu'on lui passe l'entité sur laquelle on souhaite travailler
 */
class PaginationService {

    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;
    private $twig;
    private $route;
    private $templatePath;
    private $category;
    private $pageCategory;

    public function __construct(EntityManagerInterface $manager, Environment $twig, RequestStack $request, string $templatePath, PageRepository $pageRepo) {
        // On récupère le nom de la route à utiliser à partir des attributs de la requête actuelle
        $this->route        = $request->getCurrentRequest()->attributes->get('_route');

        //$l = ($request->getCurrentRequest()->attributes->get('page') == 1) ? 0 : strlen($request->getCurrentRequest()->attributes->get('page'))+1;
        //$var = $request->getCurrentRequest()->getPathInfo();
        //$pageCategory = substr($var, 1, ($l===0) ? null : -$l);
        $this->pageCategory = $request->getCurrentRequest()->attributes->get('pageCategory');
        //dump($this->pageCategory);
        //die();
        // Autres initialisations
        $this->manager      = $manager;
        $this->twig         = $twig;
        $this->templatePath = $templatePath;
        $this->category = $pageRepo->findBy(['codeName' => $this->pageCategory], [], null, null);
        /*dump($pageRepo->findBy(['codeName' => $pageCategory], [], null, null), $pageCategory);
        die();*/
    }

    public function getPageCategory(){
        return $this->pageCategory;
    }

    public function display() {
        $this->twig->display($this->templatePath, [
            'page' => $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route,
            'pageCategory' => $this->pageCategory,
        ]);

        //dump($this->currentPage, $this->getPages(), $this->route);
    }

    public function getPages(): int {
        if(empty($this->entityClass)) {
            // Si il n'y a pas d'entité configurée, on ne peut pas charger le repository, la fonction
            // ne peut donc pas continuer !
            throw new \Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devons paginer ! Utilisez la méthode setEntityClass() de votre objet PaginationService !");
        }

        // 1) Connaitre le total des enregistrements de la table
        $total = count($this->manager
            ->getRepository($this->entityClass)
        //Mettre ici la requete pour la cible dans post
            ->findByPage($this->category));

        // 2) Faire la division, l'arrondi et le renvoyer
        return ceil($total / $this->limit);
    }

    public function getData() {
        if(empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devons paginer ! Utilisez la méthode setEntityClass() de votre objet PaginationService !");
        }
        // 1) Calculer l'offset
        $offset = $this->currentPage * $this->limit - $this->limit;

        // 2) Demander au repository de trouver les éléments à partir d'un offset et
        // dans la limite d'éléments imposée (voir propriété $limit)
        return $this->manager
            ->getRepository($this->entityClass)
            //Mettre ici la requete pour la cible dans post
            ->findBy(['page'=>$this->category], [], $this->limit, $offset);
    }


    public function setPage(int $page): self {
        $this->currentPage = $page;

        return $this;
    }

    public function getPage(): int {
        return $this->currentPage;
    }

    public function setLimit(int $limit): self {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit(): int {
        return $this->limit;
    }

    public function setEntityClass(string $entityClass): self {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass(): string {
        return $this->entityClass;
    }

    public function setTemplatePath(string $templatePath): self {
        $this->templatePath = $templatePath;

        return $this;
    }

    public function getTemplatePath(): string {
        return $this->templatePath;
    }

    public function setRoute(string $route): self {
        $this->route = $route;

        return $this;
    }

    public function getRoute(): string {
        return $this->route;
    }
}
