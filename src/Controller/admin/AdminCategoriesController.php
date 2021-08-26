<?php

namespace App\Controller\admin;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoriesController extends AbstractController
{

    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function categories(CategoriesRepository $categoriesRepository)
    {
        // je dois faire une requête SQL SELECT en bdd
        // sur la table article
        // La classe qui me permet de faire des requêtes SELECT est ArticleRepository
        // donc je dois instancier cette classe
        // pour ça, j'utilise l'autowire (je place la classe en argument du controleur,
        // suivi de la variable dans laquelle je veux que sf m'instancie la classe
        $categories = $categoriesRepository->findAll();

        return $this->render('admin/admin_categories.html.twig', [
            'categories' => $categories
        ]);
    }
    /**
     * @Route("/admin/categorie/insert", name="admin_categorie_Insert")
     */
    public function insertCategorie(
        EntityManagerInterface $entityManager
    )
    {
        // J'utilise l'entité Article, pour créer un nouvel article en bdd
        // une instance de l'entité Article = un enregistrement d'article en bdd
        $categories = new categories;
        // j'utilise les setters de l'entité Article pour renseigner les valeurs
        // des colonnes
        $categories->setTitle('Titre categorie depuis le controleur');
        $categories->setCreatedAt(new \DateTime('NOW'));

        // je prends toutes les entités créées (ici une seule) et je les "pré-sauvegarde"
        $entityManager->persist($categories);

        // je récupère toutes les entités pré-sauvegardées et je les insère en BDD
        $entityManager->flush();

        return $this->redirectToRoute('admin_categories');
    }

    /**
     * @Route("/admin/categorie/update/{id}", name="admin_categorie_Update")
     */
    public function updateCategorie($id, CategoriesRepository $categoriesRepository, EntityManagerInterface $entityManager)
    {
        $categories = $categoriesRepository->find($id);

        $categories->setTitle("titre update");

        $entityManager->persist($categories);
        $entityManager->flush();

        return $this->redirectToRoute('admin_categories');
    }

    /**
     * @Route("/admin/categorie/delete/{id}",name="admin_categorie_Delete")
     */
    public function deleteCategorie($id,CategoriesRepository $categoriesRepository,EntityManagerInterface $entityManager)
    {
        $categories= $categoriesRepository->find($id);
        $entityManager->remove($categories);
        //prend tous et direction la bdd
        $entityManager->flush();

        //redirige vers la page article_list
        return $this->redirectToRoute('admin_categories');
    }

    public function categoriesAll(CategoriesRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('front/_categories_all.html.twig', [
            'categories' => $categories
        ]);
    }

}


