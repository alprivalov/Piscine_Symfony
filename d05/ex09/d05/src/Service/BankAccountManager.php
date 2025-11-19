<?php
namespace App\Service;

use App\Entity\BankAccount;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\MigratorConfiguration;
use Doctrine\Migrations\Version\Version;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

class BankAccountManager{

    private DependencyFactory $dependencyFactory;
    private EntityManagerInterface $em;

    public function __construct(DependencyFactory $dependencyFactory, EntityManagerInterface $em){
        $this->dependencyFactory = $dependencyFactory;
        $this->em = $em;
    }

    public function createTable(){
        try{
            $config = new MigratorConfiguration();
            $config->setDryRun(false);
            
            $version = new Version('DoctrineMigrations\\Version20250925114911');
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
}