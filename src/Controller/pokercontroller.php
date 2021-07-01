
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController
{
    /**
     * @Route("/", name="home")
     */
    public function home(){

        // Je retourne une réponse HTTP valide en utilisant
        // la class Response du composant HttpFoundation
        return new Response('Accueil');
    }

    /**
     * @Route("/legal", name="legal")
     */
    public function legal(){
        return new Response('Mentions légales');
    }

}