<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CreateTableController extends AbstractController
{
    #[Route('e02/create/table', name: 'app_create_table')]
    public function index(Connection $connection): Response
    {

        $sql = '
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                username VARCHAR(255) UNIQUE,
                name VARCHAR(255),
                email VARCHAR(255) UNIQUE,
                enable BOOLEAN,
                birthdate TIMESTAMP,
                address TEXT
            )
        ';

        $connection->executeQuery($sql);

        return new Response('Table "users" created successfully (if it did not exist).');
    }
}
