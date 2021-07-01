<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class pokercontroller extends AbstractController
{
    /**
     * @Route("/poker", name="poker")
     */
    public function poker()
    {

        // j'utilise la classe Request du composant HTTPFoundation
        // et la méthode createFromGlobals qui met permet de récupérer
        // tous les parametre GET / POST etc
        $request = Request::createFromGlobals();

        // je stocke dans une variable $request la valeur
        // du parametre GET 'sent'
        $age = $request->query->get('age');

        // si le parametre GET 'sent' est égal à 'yes' alors j'envoie
        // une réponse avec 'merci pour le form'
        if ($age >= 18) {
            return new Response("Bienvenue");
            // sinon je renvoie le formulaire en réponse
        } else {
            return $this->redirectToRoute('Gros Noob');
        }
    }

    /**
     * @Route("/Gros Noob", name="Gros Noob")
     */
    public function Noob()
    {
        return new Response("Va a la maternelle");
    }
}