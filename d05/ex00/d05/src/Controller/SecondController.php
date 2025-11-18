<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
class SecondController extends AbstractController {

    #[Route('e00/create',name:'e00_create')]
    public function create_user(Connection $connection) {
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

        } catch (\Exception $e) {

        }
        return $this->render('e00/e00.success.html.twig');
    }
}