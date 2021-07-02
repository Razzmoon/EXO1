<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use  Symfony\Component\Routing\Annotation\Route;

class pokercontroller extends AbstractController

{
    /**
     * @Route("/poker", name="poker")
     */
    public function poker(Request $request)
    {
        $age = $request->query->get('age');

        if ($age >= 18) {
            return new Response("Bienvenue");
            // sinon je renvoie le formulaire en réponse
        } else {
            // je fais une redirection vers la route redirect
            // grâce à la méthode redirectToRoute qui existe dans
            // l'AbstractController
            // Ma classe PageController hérite d'AbstractController
            // donc elle hérite aussi de la méthode redirectToRoute
            return $this->redirectToRoute("noob");
        }
    }


    /**
     * @Route("/Noob", name="noob")
     */
    public function noob()
    {
        //return new Response("Gros Noob");
        return $this->render('index.html');
    }
}
