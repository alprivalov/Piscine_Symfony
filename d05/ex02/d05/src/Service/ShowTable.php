<?php
namespace App\Service;

use Doctrine\DBAL\Connection;

class ShowTable {
    private Connection $connection;
    public function __construct(Connection $connection){
        $this->connection = $connection;
    }
    
    public function getData(){
        $sql_check_table = "SELECT to_regclass('users')";
        if(!$this->connection->fetchOne($sql_check_table))
            return [];
        
        $sql = 'SELECT * FROM users';
        
        $data = $this->connection->fetchAllAssociative($sql);
        return $data;
    }
}