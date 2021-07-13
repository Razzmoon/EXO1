<?php

namespace App\Controller\admin;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class AdmintagController extends AbstractController
{

    /**
     * @Route("/admin/tags", name="admin_tagList")
     */
    public function tagList(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();

        return $this->render('Admin/admin_tag_list.html.twig', [
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/admin/tag/insert", name="admin_tag_Insert")
     */
    public function insertTags(
        EntityManagerInterface $entityManager
    )
    {
        // J'utilise l'entité Article, pour créer un nouvel article en bdd
        // une instance de l'entité Article = un enregistrement d'article en bdd
        $tags = new tag;
        // j'utilise les setters de l'entité Article pour renseigner les valeurs
        // des colonnes
        $tags->setTitle('Titre tag depuis le controleur');

        // je prends toutes les entités créées (ici une seule) et je les "pré-sauvegarde"
        $entityManager->persist($tags);

        // je récupère toutes les entités pré-sauvegardées et je les insère en BDD
        $entityManager->flush();

        return $this->redirectToRoute('admin_tagList');
    }

    /**
     * @Route("/admin/tags/update/{id}", name="admin_tag_Update")
     */
    public function updateTag($id, tagRepository $tagsRepository, EntityManagerInterface $entityManager)
    {
        $tag = $tagsRepository->find($id);

        $tag->setTitle("titre update");

        $entityManager->persist($tag);
        $entityManager->flush();

        return $this->redirectToRoute('admin_tagList');
    }

    /**
     * @Route("/admin/tags/delete/{id}",name="admin_tag_Delete")
     */
    public function deletetag($id,tagRepository $tagsRepository,EntityManagerInterface $entityManager)
    {
        $tag= $tagsRepository->find($id);
        $entityManager->remove($tag);
        //prend tous et direction la bdd
        $entityManager->flush();

        //redirige vers la page article_list
        return $this->redirectToRoute('admin_tagList');
    }

}