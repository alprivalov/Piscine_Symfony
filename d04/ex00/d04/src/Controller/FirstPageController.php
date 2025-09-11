<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstPageController 
{
    #[Route('/e00/firstpage', name: 'firstpage')]
    public function firstpage(): Response
    {
        return new Response('Hello world!');
    }
}
