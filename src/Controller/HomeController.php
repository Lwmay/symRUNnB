<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

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
