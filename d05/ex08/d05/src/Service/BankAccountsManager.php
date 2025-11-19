<?php
namespace App\Service;

use Doctrine\DBAL\Connection;

class BankAccountsManager {
    private Connection $connection;

    private function verifyTable($table){
        $sql_check_table = "SELECT to_regclass('". $table ."')";
        if(!$this->connection->fetchOne($sql_check_table))
            return false;
        return true;
    }

    public function createBank_accountsTable(){
        $sql = '
            CREATE TABLE IF NOT EXISTS bank_accounts (
                id SERIAL PRIMARY KEY,
                money INT
            )
        ';

        if(!$this->verifyTable("bank_accounts"))
            $this->connection->executeQuery($sql);
    }
    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }


    private function alterPerson_id(){

        $sqlVerifyPerson_id = "SELECT 1
            FROM information_schema.columns
            WHERE table_name = 'bank_accounts' AND column_name = 'person_id'
        ";
        if(!$this->connection->fetchOne($sqlVerifyPerson_id)){

            $sql = "ALTER TABLE bank_accounts
                ADD person_id INT 
            ";
            $this->connection->executeQuery($sql);
        }

    }
    public function createBank_accounts(){
        if(!$this->verifyTable("bank_accounts"))
            return false;

        $this->alterPerson_id();

        $sqlVerifyPerson_id = "SELECT 1
            FROM pg_constraint
            WHERE conname = 'fk_persons_bank_accounts';
        ";

        if(!$this->connection->fetchOne($sqlVerifyPerson_id)){
            $sql = "ALTER TABLE bank_accounts
                ADD CONSTRAINT fk_persons_bank_accounts FOREIGN KEY (person_id) REFERENCES persons(id);
            ";
            $this->connection->executeQuery($sql);
            return true;
        }
        return false;
    }

}