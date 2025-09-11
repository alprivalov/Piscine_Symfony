<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FirstPageController extends AbstractController
{
    #[Route('/e00/firstpage', name: 'firstpage')]
    public function firstpage(): Response
    {
        return $this->render('e00/firstpage.html.twig');
    }
}
