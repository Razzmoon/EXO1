<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Entity\Tag;
use App\Form\ArticleType;
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
     * @Route("/admin/articles/insert", name="admin_article_insert")
     */
    public function insertArticle()
    {
        $article = new Article();

        $articleForm = $this->createForm(ArticleType::class, $article);

        return $this->render('Admin/admin_insert.html.twig', [
            'articleForm' => $articleForm->createView()
        ]);
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


