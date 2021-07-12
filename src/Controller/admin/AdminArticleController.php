<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\CategoriesRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    /**
     * @Route("/admin/articles", name="admin_article_List")
     */
    public function articleList(ArticleRepository $articleRepository)
    {
        // je dois faire une requête SQL SELECT en bdd
        // sur la table article
        // La classe qui me permet de faire des requêtes SELECT est ArticleRepository
        // donc je dois instancier cette classe
        // pour ça, j'utilise l'autowire (je place la classe en argument du controleur,
        // suivi de la variable dans laquelle je veux que sf m'instancie la classe
        $articles = $articleRepository->findAll();

        return $this->render('Admin/admin_article_list.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("admin/search", name="admin_search")
     */
    public function search(ArticleRepository $articleRepository, Request $request)
    {
        $term = $request->query->get('q');

        $articles = $articleRepository->search($term);

        return $this->render('article_search.html.twig', [
            'articles' => $articles,
            'term' => $term
        ]);
    }

    /**
     * @Route("/article/insert", name="admin_article_Insert")
     */
    public function insertArticle(
        EntityManagerInterface $entityManager,
        CategoriesRepository $categoryRepository,
        TagRepository $tagRepository
    )
    {
        // J'utilise l'entité Article, pour créer un nouvel article en bdd
        // une instance de l'entité Article = un enregistrement d'article en bdd
        $article = new Article();

        // j'utilise les setters de l'entité Article pour renseigner les valeurs
        // des colonnes
        $article->setTitle('Titre article depuis le controleur');
        $article->setContent('blablalbla');
        $article->setIsPublished(true);
        $article->setCreatedAt(new \DateTime('NOW'));

        // je récupère la catégorie dont l'id est 1 en bdd
        // doctrine me créé une instance de l'entité category avec les infos de la catégorie de la bdd
        $category = $categoryRepository->find(1);
        // j'associé l'instance de l'entité categorie récupérée, à l'instane de l'entité article que je suis
        // en train de créer
        $article->setCategorie($category);

        $tag = $tagRepository->findOneBy(['title' => 'info']);

        if (is_null($tag)) {
            $tag = new Tag();
            $tag->setTitle("info");
            $tag->setColor("blue");
        }

        $entityManager->persist($tag);

        $article->setTag($tag);

        // je prends toutes les entités créées (ici une seule) et je les "pré-sauvegarde"
        $entityManager->persist($article);

        // je récupère toutes les entités pré-sauvegardées et je les insère en BDD
        $entityManager->flush();

        return $this->redirectToRoute('admin_article_List');
    }

    /**
     * @Route("/articles/update/{id}", name="admin_article_Update")
     */
    public function updateArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

        $article->setTitle("titre update");

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('admin_article_List');
    }

    /**
     * @Route("/article/delete/{id}",name="admin_article_Delete")
     */
    public function deleteArticle($id,ArticleRepository $articleRepository,EntityManagerInterface $entityManager)
    {
     $article= $articleRepository->find($id);
     $entityManager->remove($article);
    //prend tous et direction la bdd
     $entityManager->flush();

     //redirige vers la page article_list
     return $this->redirectToRoute('admin_article_List');
    }


}


