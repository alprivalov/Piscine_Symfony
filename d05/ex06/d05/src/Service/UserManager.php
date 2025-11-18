<?php
namespace App\Service;

use Doctrine\DBAL\Connection;

class UserManager {
    private Connection $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function createUser(array $form){
        $sql_check_table = "SELECT to_regclass('users')";
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

        if(!$this->connection->fetchOne($sql_check_table))
            $this->connection->executeQuery($sql);

        $form['birthdate'] = $form['birthdate']->format('Y-m-d');
        $sqlVerify = 'SELECT id FROM users WHERE username = :username OR email = :email';

        if($this->connection->fetchAssociative($sqlVerify,[
            'username' => $form['username'],
            'email' => $form['email'],
        ]))
            return ;
        
        return $this->connection->insert("users",$form);
    }

    public function getUser(int $id){
        $sql = "SELECT * FROM users WHERE id = :id";
        return $this->connection->fetchAssociative($sql,[
            "id"=> $id,
        ]);
    }

    public function updateUser(array $data){
        $data["birthdate"] = $data["birthdate"]->format('Y-m-d');
        return $this->connection->update("users",$data,[
            "id"=> $data["id"],
        ]);
    }
    public function getUsers(){
        $sql = "SELECT * FROM users";
        return $this->connection->fetchAllAssociative($sql);
    }

    public function createTable(Connection $connection){
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
    }
    
}