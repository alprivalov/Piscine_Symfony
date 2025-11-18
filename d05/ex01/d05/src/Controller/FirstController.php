<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
class FirstController extends AbstractController {

    #[Route('e01',name:'e01_main')]
    public function user(Connection $connection) {
        return $this->render('base.html.twig');
    }
}