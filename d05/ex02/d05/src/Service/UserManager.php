<?php
namespace App\Service;

use Doctrine\DBAL\Connection;

class UserManager {
    private Connection $connection;
    public function __construct(Connection $connection){
        $this->connection = $connection;
    }
    
    public function createUser(array $data){
        $sql_check_table = "SELECT to_regclass('users')";

        if(!$this->connection->fetchOne($sql_check_table))
            return "Error: table doesn't exist";

        $data['birthdate'] = $data['birthdate']->format('Y-m-d H:i:s');
        $sql_user_email = 'SELECT id FROM users WHERE username = :username OR email = :email';

        $existing = $this->connection->fetchAssociative($sql_user_email,
        [
                'username'=> $data['username'],
                'email' => $data['email'], 
        ]);
        if($existing)
            return "Error: user or email already exist";
        

        $this->connection->insert('users',$data);

        return "Success: user created";
    }
}