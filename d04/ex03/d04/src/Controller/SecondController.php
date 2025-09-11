<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecondController extends AbstractController
{

    #[Route('/e01', name: 'e01_main')]
    #[Route('/e01/{article?}', name: 'article')]
    public function article(?string $article = null): Response
    {
        $route = ["cat", "tree","gull"];
        if ($article != null && array_search($article,$route) !== false)
            return $this->render("e01/{$article}.html.twig");
        return $this->render('e01/main.html.twig');
    }
}
