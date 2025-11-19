<?php 
?><?php
namespace App\Service;

use App\Entity\Persons;
use App\Repository\PersonsRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Migrations\MigratorConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Version\Version;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

class PersonsManager{
    private DependencyFactory $dependencyFactory;
    private EntityManagerInterface $em;
    private Connection $connection;
    public function __construct(DependencyFactory $dependencyFactory, EntityManagerInterface $em, Connection $connection){
        $this->dependencyFactory = $dependencyFactory;
        $this->em = $em;
        $this->connection = $connection;
    }

    public function getTable(){

        $meta = $this->em->getClassMetadata(Persons::class);
        $headers = $meta->getFieldNames();
        $repos = [];
        try{
               
            $sql =  "SELECT * FROM persons";
            $repos = $this->connection->fetchAllAssociative($sql);
        }catch(\Exception $e){
            return [];
        }
        return [$repos,$headers];
    }
    public function createPersons(array $persons){
        try{
            $persons['birthdate'] = $persons['birthdate']->format('Y-m-d');

            $this->connection->insert("persons",$persons);
            return true;
        } catch(\Exception $e){
            return false;
        }
    }

    public function updatePersons(){
        $this->em->flush();
        return true;
    }
    public function getPersons($id){
        return $this->em->getRepository(Persons::class)->find($id);
    }

    public function createTable(){
        try{
            $config = new MigratorConfiguration();
            $config->setDryRun(false);
            
            $version = new Version('DoctrineMigrations\\Version20250925114716');
            $plan = $this->dependencyFactory->getMigrationPlanCalculator()
                ->getPlanUntilVersion( $version);

            $this->dependencyFactory->getMigrator()
                ->migrate($plan,$config);

            return true;
        } catch(\Exception $e){
            return false;
        }
    }


    public function alternate(){
        try{
            $config = new MigratorConfiguration();
            
            $version = new Version('DoctrineMigrations\\Version20250925114819');
            $plan = $this->dependencyFactory
                ->getMigrationPlanCalculator()
                ->getPlanUntilVersion( $version);

            $this->dependencyFactory->getMigrator()
                ->migrate($plan,$config);

            return true;
        } catch(\Exception $e){
            return false;
        }
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