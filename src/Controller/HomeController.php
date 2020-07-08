<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
    /**
     * @Route("/hello/{prenom}", name="hello")
     * @Route("/hello", name="hello_base}
     * Montre la page qui dit bonjour
     *
     * @return Response
     */
    public function hello($prenom = anonyme) {
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => age
            ]
        );
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home()
    {
        $prenoms = ["Laurent" => 31, "Fredo" => 26, "Alexis" => 12];
        return $this->render(
            'home.html.twig',
            [
                'title' => "Bonjour à tous",
                'age' => 31,
                'tableau' => $prenoms
            ]
        );
    }
}
