<?php

namespace App\Service;

use Doctrine\Migrations\DependencyFactory;

class MigrationManager{
    private DependencyFactory $dependencyFactory;

    public function __construct(DependencyFactory $dependencyFactory){
        $this->dependencyFactory = $dependencyFactory;
    }

    public function initialise(){
        $factory = $this->dependencyFactory->getMetadataStorage();
        $factory->ensureInitialized();
    }
}