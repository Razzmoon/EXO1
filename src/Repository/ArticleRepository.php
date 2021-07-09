<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // fonction qui recupere la variable term pour fair une recherche
    public function searchByTerm($term)
    {
        //SA J'ai pas compris
        $queryBuilder = $this->createQueryBuilder('article');

        //une sorte de requete sql mais differente qui permet d'aller dans article et de chercher ce qu'on veux en fonction de term
        $query = $queryBuilder
            ->select('article')

            ->where('article.content LIKE :term')
            ->setParameter('term', '%'.$term.'%')

            //transforme la sorte de requette sql en vrai requette sql
            ->getQuery();

        return $query->getResult();
    }

}
