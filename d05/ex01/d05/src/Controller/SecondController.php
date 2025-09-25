<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
class SecondController extends AbstractController {

    #[Route('e04',name:'e04_main')]
    public function tesT(Connection $connection) {
        $sql = '
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                username varchar(255) UNIQUE,
                name varchar(255),
                email varchar(255) UNIQUE,
                enable BOOLEAN,
                birthdate TIMESTAMP,
                address TEXT
            )
        ';

        try {
            $connection->executeStatement($sql);
            $message = 'Table created (or already exists)';
        } catch (\Exception $e) {
            $message = 'Error: ' . $e->getMessage();
            return $this->render('e00/e00.error.html.twig',['error'=>$e->getMessage()]);
        }
        return $this->render('e00/e00.success.html.twig');
    }
}