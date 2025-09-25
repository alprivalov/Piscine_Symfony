<?php 
namespace App\Service;

use Doctrine\DBAL\Connection;

class UserManager {
    private Connection $connection;
    public function __construct(Connection $connection){
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
    public function deleteUser($userId){
        return $this->connection->delete("users",[
            'id' => $userId
        ]);
    }

    public function getUsers(){
        $sql = "SELECT * FROM users";
        return $this->connection->fetchAllAssociative($sql);
    }

}