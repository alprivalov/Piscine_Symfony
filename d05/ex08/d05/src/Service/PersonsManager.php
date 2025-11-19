<?php
namespace App\Service;

use Doctrine\DBAL\Connection;

class PersonsManager {
    private Connection $connection;
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }
    private function verifyTable($table){
        $sql_check_table = "SELECT to_regclass('". $table ."')";
        if(!$this->connection->fetchOne($sql_check_table))
            return false;
        return true;
    }
    private function verifyType(){
        
        $sqlVerityTypeExist = "SELECT 1 FROM pg_type WHERE typname = 'status'";
        if (!$this->connection->fetchOne($sqlVerityTypeExist))
            return false;
        return true;
    }

    private function createType(){
        $sqlType = "CREATE TYPE status AS ENUM ('single', 'married', 'widower');";
        $this->connection->executeStatement($sqlType);
    }

    public function createPersonsTable( ){
        $sql = '
            CREATE TABLE IF NOT EXISTS persons (
                id SERIAL PRIMARY KEY,
                username varchar(255) UNIQUE,
                name varchar(255),
                email varchar(255) UNIQUE,
                enable BOOLEAN,
                birthdate TIMESTAMP
            )
        ';

        if(!$this->verifyTable("persons"))
            $this->connection->executeQuery($sql);
    }

    public function createPersons(array $form){
        if(!$this->verifyTable("persons"))
            return ;
        $form['birthdate'] = $form['birthdate']->format('Y-m-d');
        $sqlVerify = 'SELECT id FROM persons WHERE username = :username OR email = :email';

        if($this->connection->fetchAssociative($sqlVerify,[
            'username' => $form['username'],
            'email' => $form['email'],
        ]))
            return ;
        
        return $this->connection->insert("persons",$form);
    }

    public function getPerson(int $id){

        if(!$this->verifyTable("persons"))
            return ;
        $sql = "SELECT * FROM persons WHERE id = :id";
        return $this->connection->fetchAssociative($sql,[
            "id"=> $id,
        ]);
    }

    public function getPersons(){
        if(!$this->verifyTable("persons"))
            return ;
        $sql = "SELECT * FROM persons";
        return $this->connection->fetchAllAssociative($sql);
    }
    
    public function addColumn(){
        if(!$this->verifyType())
            $this->createType();

        $sqlTable = "SELECT 1
            FROM information_schema.columns
            WHERE table_name = 'persons' AND column_name = 'marital_status'
        ";


        if(!$this->connection->fetchOne($sqlTable) && $this->verifyTable("persons")){
            $sql = "
                ALTER TABLE persons
                ADD marital_status status
            ";
            $this->connection->executeStatement($sql);
            return true;
        }
        return false;
    }
    public function addRelations(){
        return true;
    }
    public function getPersonsColumns()
    {
        $sql = "
            SELECT column_name, data_type
            FROM information_schema.columns
            WHERE table_name = 'persons'
        ";

        return $this->connection->fetchAllAssociative($sql);
    }
    
}