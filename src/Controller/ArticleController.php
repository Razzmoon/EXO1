<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use  Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route ("/articles", name="articles")
     */
    public function list (){
        return new Response("Liste d'articles");
    }
}

