<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{

    /**
     * @Route("/categories", name="categories")
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

        return $this->render('categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="categorieShow")
     */
    public function categorieShow($id, CategoriesRepository $categoriesRepository)
    {
        // afficher un article en fonction de l'id renseigné dans l'url (en wildcard)
        $categorie = $categoriesRepository->find($id);

        return $this->render('categories_show.html.twig', [
            'categories' => $categorie
        ]);
    }


}


