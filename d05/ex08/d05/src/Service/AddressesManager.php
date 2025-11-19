<?php
namespace App\Service;

use Doctrine\DBAL\Connection;

class AddressesManager {
    private Connection $connection;

    private function verifyTable($table){
        $sql_check_table = "SELECT to_regclass('". $table ."')";
        if(!$this->connection->fetchOne($sql_check_table))
            return false;
        return true;
    }
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }
    public function createAddressesTable( ){
        $sql = '
            CREATE TABLE IF NOT EXISTS addresses (
                id SERIAL PRIMARY KEY,
                address varchar(255)
            )
        ';

        if(!$this->verifyTable("addresses"))
            $this->connection->executeQuery($sql);
    }


    private function alterPerson_id(){

        $sqlVerifyPerson_id = "SELECT 1
            FROM information_schema.columns
            WHERE table_name = 'addresses' AND column_name = 'person_id'
        ";
        if(!$this->connection->fetchOne($sqlVerifyPerson_id)){

            $sql = "ALTER TABLE addresses
                ADD person_id INT UNIQUE
            ";
            $this->connection->executeQuery($sql);
        }

    }
    
    public function createAddresse(){
        if(!$this->verifyTable("addresses"))
            return false;
        
        $this->alterPerson_id();

        $sqlVerifyPerson_id = "SELECT 1
            FROM pg_constraint
            WHERE conname = 'fk_persons_addresse';
        ";

        if(!$this->connection->fetchOne($sqlVerifyPerson_id)){
            $sql = "ALTER TABLE addresses
                ADD CONSTRAINT fk_persons_addresse FOREIGN KEY (person_id) REFERENCES persons(id);
            ";
            $this->connection->executeQuery($sql);
            return true;
        }
        return false;
    }
}