<?php
namespace App\Service;

use App\Entity\BankAccount;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

class BankAccountManager{

    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    public function createTable(){
        try{
            $metadata =[ $this->em->getClassMetadata(BankAccount::class)];

            $schematool = new SchemaTool($this->em);
            
            $schematool->createSchema($metadata);
            return true;
        } catch(\Exception $e){
            return false;
        }
    }
}