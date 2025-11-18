<?php
namespace App\Service;

use Doctrine\DBAL\Connection;

class UserManager {
    private Connection $connection;
    public function __construct(Connection $connection){
        $this->connection = $connection;
    }
    
    public function createUser(array $data){
        $data['birthdate'] = $data['birthdate']->format('Y-m-d H:i:s');
        $this->connection->insert('users',$data);
    }
}